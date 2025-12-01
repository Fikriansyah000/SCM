<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\ServiceExtension;
use App\Models\ServiceProposal;
use App\Services\OrderNotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceWorkflowController extends Controller
{
    protected OrderNotificationService $notificationService;

    public function __construct(OrderNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * List all service proposals for the seller
     */
    public function proposals(Request $request)
    {
        $shop = auth()->user()->shop;
        
        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        $query = ServiceProposal::where('seller_id', auth()->id())
            ->with(['product', 'buyer', 'order']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Default: show pending first, then others
        $proposals = $query->orderByRaw("FIELD(status, 'pending', 'negotiating', 'accepted', 'in_progress', 'review', 'revision') DESC")
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('seller.services.proposals', compact('proposals'));
    }

    /**
     * Show single proposal detail
     */
    public function showProposal(ServiceProposal $proposal)
    {
        $this->authorizeSeller($proposal);

        $proposal->load(['product', 'buyer', 'order.items', 'order.orderEvents' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }]);

        return view('seller.services.proposal-show', compact('proposal'));
    }

    /**
     * Accept a proposal - marks as accepted, waiting for buyer payment
     */
    public function acceptProposal(Request $request, ServiceProposal $proposal)
    {
        $this->authorizeSeller($proposal);

        if (!$proposal->canBeAccepted()) {
            return back()->with('error', 'Proposal tidak dapat diterima pada status ini.');
        }

        $validated = $request->validate([
            'agreed_price' => 'nullable|numeric|min:10000',
            'agreed_deadline' => 'nullable|date|after:today',
            'response_message' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($proposal, $validated) {
            $proposal->update([
                'status' => ServiceProposal::STATUS_ACCEPTED,
                'agreed_price' => $validated['agreed_price'] ?? null,
                'agreed_deadline' => isset($validated['agreed_deadline']) ? Carbon::parse($validated['agreed_deadline']) : null,
                'responded_at' => now(),
                'notes' => $validated['response_message'] ?? null,
            ]);

            // Note: Order will be created when buyer pays (via ServiceOrderController@payProposal)
            
            $this->notificationService->proposalAccepted($proposal);
        });

        return back()->with('success', 'Proposal diterima! Menunggu pembayaran dari pembeli.');
    }

    /**
     * Reject a proposal
     */
    public function rejectProposal(Request $request, ServiceProposal $proposal)
    {
        $this->authorizeSeller($proposal);

        if (!$proposal->canBeAccepted()) {
            return back()->with('error', 'Proposal tidak dapat ditolak pada status ini.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:1000',
        ]);

        DB::transaction(function () use ($proposal, $validated) {
            $proposal->update([
                'status' => ServiceProposal::STATUS_REJECTED,
                'responded_at' => now(),
                'notes' => $validated['rejection_reason'],
            ]);

            // Note: No order to cancel in the new flow (order is only created after payment)

            $this->notificationService->proposalRejected($proposal, $validated['rejection_reason']);
        });

        return back()->with('success', 'Proposal ditolak.');
    }

    /**
     * Start working on a proposal (manual start after payment)
     */
    public function startWork(ServiceProposal $proposal)
    {
        $this->authorizeSeller($proposal);

        // Can only start work if payment has been made (order exists)
        if (!$proposal->order_id) {
            return back()->with('error', 'Menunggu pembayaran dari pembeli terlebih dahulu.');
        }

        if (!$proposal->canStartWork()) {
            return back()->with('error', 'Pengerjaan tidak dapat dimulai pada status ini.');
        }

        DB::transaction(function () use ($proposal) {
            $proposal->update([
                'status' => ServiceProposal::STATUS_IN_PROGRESS,
                'started_at' => now(),
            ]);

            if ($proposal->order) {
                $proposal->order->update([
                    'service_status' => 'in_progress',
                    'status' => 'processing',
                ]);
            }

            $this->notificationService->workStarted($proposal);
        });

        return back()->with('success', 'Pengerjaan dimulai! Buyer telah diberi notifikasi.');
    }

    /**
     * Submit work for review
     */
    public function submitReview(Request $request, ServiceProposal $proposal)
    {
        $this->authorizeSeller($proposal);

        if (!in_array($proposal->status, [ServiceProposal::STATUS_IN_PROGRESS, ServiceProposal::STATUS_REVISION])) {
            return back()->with('error', 'Tidak dapat mengirim hasil pada status ini.');
        }

        $validated = $request->validate([
            'submission_notes' => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($proposal, $validated) {
            $proposal->update([
                'status' => ServiceProposal::STATUS_REVIEW,
            ]);

            if ($proposal->order) {
                $proposal->order->update([
                    'service_status' => 'review',
                ]);
            }

            $this->notificationService->reviewSubmitted($proposal, $validated['submission_notes'] ?? null);
        });

        return back()->with('success', 'Hasil pekerjaan dikirim untuk review buyer.');
    }

    /**
     * Request a deadline extension
     */
    public function requestExtension(Request $request, ServiceProposal $proposal)
    {
        $this->authorizeSeller($proposal);

        // Can only request extension if work is in progress or revision
        if (!in_array($proposal->status, [ServiceProposal::STATUS_IN_PROGRESS, ServiceProposal::STATUS_REVISION])) {
            return back()->with('error', 'Perpanjangan hanya dapat diminta saat pengerjaan.');
        }

        // Check for existing pending extension
        if ($proposal->order && $proposal->order->hasPendingExtension()) {
            return back()->with('error', 'Sudah ada permintaan perpanjangan yang menunggu respon buyer.');
        }

        $validated = $request->validate([
            'extension_days' => 'required|integer|min:1|max:30',
            'reason' => 'required|string|min:20|max:1000',
        ]);

        $order = $proposal->order;
        $currentDeadline = $order->service_due_at ?? $proposal->getFinalDeadline();
        $newDeadline = Carbon::parse($currentDeadline)->addDays($validated['extension_days']);

        DB::transaction(function () use ($order, $validated, $currentDeadline, $newDeadline) {
            $extension = ServiceExtension::create([
                'order_id' => $order->id,
                'requested_by' => auth()->id(),
                'extension_days' => $validated['extension_days'],
                'reason' => $validated['reason'],
                'original_deadline' => $currentDeadline,
                'new_deadline' => $newDeadline,
                'status' => ServiceExtension::STATUS_PENDING,
                'auto_approve_at' => now()->addHours(ServiceExtension::AUTO_APPROVE_HOURS),
            ]);

            $this->notificationService->extensionRequested($extension);
        });

        return back()->with('success', 'Permintaan perpanjangan dikirim ke buyer. Jika tidak ada respon dalam 24 jam, akan otomatis disetujui.');
    }

    /**
     * List all orders with service workflow (for unified view)
     */
    public function orders(Request $request)
    {
        $shop = auth()->user()->shop;
        
        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        $query = Order::where('shop_id', $shop->id)
            ->where('is_service_order', true)
            ->with(['user', 'serviceProposals.product', 'pendingExtension']);

        // Filter by status
        if ($request->filled('service_status')) {
            $query->where('service_status', $request->service_status);
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('seller.services.orders', compact('orders'));
    }

    /**
     * Show service order detail with timeline
     */
    public function showOrder(Order $order)
    {
        $shop = auth()->user()->shop;
        
        if ($order->shop_id !== $shop->id) {
            abort(403);
        }

        $order->load([
            'user',
            'items.product',
            'serviceProposals.product',
            'serviceProposals.buyer',
            'orderEvents' => fn($q) => $q->orderBy('created_at', 'desc'),
            'serviceExtensions' => fn($q) => $q->orderBy('created_at', 'desc'),
        ]);

        return view('seller.services.order-show', compact('order'));
    }

    /**
     * Authorize that the current user is the seller for this proposal
     */
    protected function authorizeSeller(ServiceProposal $proposal): void
    {
        if ($proposal->seller_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }
    }

    /**
     * Recalculate order total after price changes
     */
    protected function recalculateOrderTotal(Order $order): void
    {
        $itemsTotal = $order->items()->sum(DB::raw('price * quantity'));
        $order->update([
            'total_amount' => $itemsTotal + ($order->shipping_cost ?? 0),
        ]);
    }
}
