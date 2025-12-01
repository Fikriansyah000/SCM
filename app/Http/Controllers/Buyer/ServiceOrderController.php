<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\OrderItem;
use App\Models\ServiceExtension;
use App\Models\ServiceProposal;
use App\Services\OrderNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceOrderController extends Controller
{
    protected OrderNotificationService $notificationService;

    public function __construct(OrderNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * List all proposals for buyer (before they become orders)
     */
    public function proposals(Request $request)
    {
        $query = ServiceProposal::where('buyer_id', auth()->id())
            ->with(['product.shop', 'seller'])
            ->whereNull('order_id'); // Only proposals not yet converted to orders
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $proposals = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('buyer.proposals.index', compact('proposals'));
    }

    /**
     * Show single proposal detail
     */
    public function showProposal(ServiceProposal $proposal)
    {
        $this->authorizeBuyerForProposal($proposal);
        
        $proposal->load(['product.shop', 'seller', 'order']);

        return view('buyer.proposals.show', compact('proposal'));
    }

    /**
     * Pay for accepted proposal - creates the order
     */
    public function payProposal(Request $request, ServiceProposal $proposal)
    {
        $this->authorizeBuyerForProposal($proposal);

        if ($proposal->status !== ServiceProposal::STATUS_ACCEPTED) {
            return back()->with('error', 'Proposal belum disetujui oleh seller.');
        }

        if ($proposal->order_id) {
            return back()->with('error', 'Proposal ini sudah dibayar.');
        }

        DB::beginTransaction();

        try {
            $finalPrice = $proposal->getFinalPrice();
            $metadata = $proposal->metadata ?? [];

            // Create order with ORD-JS prefix for service
            $order = Order::create([
                'user_id' => auth()->id(),
                'shop_id' => $proposal->product->shop_id,
                'order_number' => Order::generateOrderNumber(true), // true = service order
                'status' => 'processing', // Langsung processing karena sudah bayar
                'total_amount' => $finalPrice,
                'shipping_address' => $metadata['shipping_address'] ?? '-',
                'shipping_method' => 'service', // Tipe khusus untuk layanan
                'shipping_mode' => 'reguler', // Use valid enum; service orders don't ship physically
                'shipping_cost' => 0,
                'total_weight' => 0,
                'estimated_delivery' => null,
                'shipping_status' => 'pending', // Use valid enum value
                'cutoff_exceeded' => false,
                'is_service_order' => true,
                'service_status' => 'in_progress',
                'service_due_at' => $proposal->getFinalDeadline(),
            ]);

            // Create order item
            $orderItem = $order->items()->create([
                'product_id' => $proposal->product_id,
                'quantity' => 1,
                'price' => $finalPrice,
                'service_details' => [
                    'description' => $proposal->description,
                    'deadline' => $proposal->getFinalDeadline()->toDateString(),
                ],
            ]);

            // Update proposal with order reference
            $proposal->update([
                'order_id' => $order->id,
                'order_item_id' => $orderItem->id,
                'status' => ServiceProposal::STATUS_IN_PROGRESS,
                'started_at' => now(),
            ]);

            // Log payment confirmed event for service timeline
            OrderEvent::create([
                'order_id' => $order->id,
                'order_item_id' => $orderItem->id,
                'service_proposal_id' => $proposal->id,
                'actor_type' => OrderEvent::ACTOR_BUYER,
                'actor_id' => auth()->id(),
                'event_type' => OrderEvent::TYPE_PAYMENT_CONFIRMED,
                'title' => 'Pembayaran Dikonfirmasi',
                'message' => 'Pembayaran berhasil. Pengerjaan layanan dimulai.',
                'visible_to_buyer' => true,
                'visible_to_seller' => true,
                'created_at' => now(),
            ]);

            // Notify seller that payment is done, work can start
            Notification::create([
                'user_id' => $proposal->seller_id,
                'title' => 'Pembayaran Diterima! 💰',
                'message' => 'Pembeli telah membayar untuk layanan "' . $proposal->product->name . '". Silakan mulai pengerjaan.',
                'type' => 'service_paid',
                'data' => [
                    'proposal_id' => $proposal->id,
                    'order_id' => $order->id,
                ],
            ]);

            DB::commit();

            return redirect()->route('buyer.services.show', $order)
                ->with('success', 'Pembayaran berhasil! Seller akan segera memulai pengerjaan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Cancel proposal before payment
     */
    public function cancelProposal(Request $request, ServiceProposal $proposal)
    {
        $this->authorizeBuyerForProposal($proposal);

        // Can only cancel if not yet paid (no order)
        if ($proposal->order_id) {
            return back()->with('error', 'Proposal sudah dibayar, gunakan pembatalan order.');
        }

        if (in_array($proposal->status, [ServiceProposal::STATUS_COMPLETED, ServiceProposal::STATUS_CANCELLED])) {
            return back()->with('error', 'Proposal tidak dapat dibatalkan.');
        }

        $validated = $request->validate([
            'cancel_reason' => 'nullable|string|max:500',
        ]);

        $proposal->update([
            'status' => ServiceProposal::STATUS_CANCELLED,
            'cancelled_at' => now(),
            'cancellation_reason' => $validated['cancel_reason'] ?? 'Dibatalkan oleh buyer',
        ]);

        // Notify seller
        Notification::create([
            'user_id' => $proposal->seller_id,
            'title' => 'Proposal Dibatalkan',
            'message' => 'Buyer membatalkan proposal untuk "' . $proposal->product->name . '".',
            'type' => 'proposal_cancelled',
            'data' => ['proposal_id' => $proposal->id],
        ]);

        return redirect()->route('buyer.proposals')
            ->with('success', 'Proposal berhasil dibatalkan.');
    }

    /**
     * Show service order detail for buyer
     */
    public function show(Order $order)
    {
        $this->authorizeBuyer($order);

        $order->load([
            'shop',
            'items.product',
            'serviceProposals.product',
            'serviceProposals.seller',
            'orderEvents' => fn($q) => $q->where('visible_to_buyer', true)->orderBy('created_at', 'desc'),
            'serviceExtensions' => fn($q) => $q->orderBy('created_at', 'desc'),
            'pendingExtension',
        ]);

        return view('buyer.orders.service-show', compact('order'));
    }

    /**
     * Approve pending extension
     */
    public function approveExtension(Request $request, ServiceExtension $extension)
    {
        $this->authorizeBuyerForExtension($extension);

        if (!$extension->isPending()) {
            return back()->with('error', 'Permintaan perpanjangan sudah diproses.');
        }

        $validated = $request->validate([
            'response_message' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($extension, $validated) {
            $extension->approve(auth()->id(), $validated['response_message'] ?? null);

            // Update order deadline
            $extension->order->update([
                'service_due_at' => $extension->new_deadline,
            ]);

            $this->notificationService->extensionApproved($extension);
        });

        return back()->with('success', 'Perpanjangan waktu disetujui. Deadline baru: ' . $extension->new_deadline->format('d M Y'));
    }

    /**
     * Reject pending extension
     */
    public function rejectExtension(Request $request, ServiceExtension $extension)
    {
        $this->authorizeBuyerForExtension($extension);

        if (!$extension->isPending()) {
            return back()->with('error', 'Permintaan perpanjangan sudah diproses.');
        }

        $validated = $request->validate([
            'response_message' => 'required|string|min:10|max:500',
        ]);

        DB::transaction(function () use ($extension, $validated) {
            $extension->reject(auth()->id(), $validated['response_message']);

            $this->notificationService->extensionRejected($extension);
        });

        return back()->with('success', 'Permintaan perpanjangan ditolak.');
    }

    /**
     * Request revision on submitted work
     */
    public function requestRevision(Request $request, ServiceProposal $proposal)
    {
        $this->authorizeBuyerForProposal($proposal);

        if ($proposal->status !== ServiceProposal::STATUS_REVIEW) {
            return back()->with('error', 'Revisi hanya dapat diminta saat status review.');
        }

        $validated = $request->validate([
            'revision_feedback' => 'required|string|min:20|max:2000',
        ]);

        DB::transaction(function () use ($proposal, $validated) {
            $proposal->update([
                'status' => ServiceProposal::STATUS_REVISION,
            ]);

            if ($proposal->order) {
                $proposal->order->update([
                    'service_status' => 'revision',
                ]);
                
                // Log revision requested event for timeline
                OrderEvent::create([
                    'order_id' => $proposal->order->id,
                    'service_proposal_id' => $proposal->id,
                    'actor_type' => OrderEvent::ACTOR_BUYER,
                    'actor_id' => auth()->id(),
                    'event_type' => OrderEvent::TYPE_REVISION_REQUESTED,
                    'title' => 'Revisi Diminta',
                    'message' => $validated['revision_feedback'],
                    'visible_to_buyer' => true,
                    'visible_to_seller' => true,
                    'created_at' => now(),
                ]);
            }

            $this->notificationService->revisionRequested($proposal, $validated['revision_feedback']);
        });

        return back()->with('success', 'Permintaan revisi dikirim ke seller.');
    }

    /**
     * Approve and complete the service
     */
    public function completeService(Request $request, ServiceProposal $proposal)
    {
        $this->authorizeBuyerForProposal($proposal);

        if ($proposal->status !== ServiceProposal::STATUS_REVIEW) {
            return back()->with('error', 'Layanan hanya dapat diselesaikan saat status review.');
        }

        DB::transaction(function () use ($proposal) {
            $proposal->update([
                'status' => ServiceProposal::STATUS_COMPLETED,
                'completed_at' => now(),
            ]);

            if ($proposal->order) {
                // Check if all proposals in this order are completed
                $allCompleted = $proposal->order->serviceProposals()
                    ->where('status', '!=', ServiceProposal::STATUS_COMPLETED)
                    ->doesntExist();

                if ($allCompleted) {
                    $proposal->order->update([
                        'service_status' => 'completed',
                        'status' => 'completed',
                        'completed_at' => now(),
                    ]);
                }
                
                // Log completion event for timeline
                OrderEvent::create([
                    'order_id' => $proposal->order->id,
                    'service_proposal_id' => $proposal->id,
                    'actor_type' => OrderEvent::ACTOR_BUYER,
                    'actor_id' => auth()->id(),
                    'event_type' => OrderEvent::TYPE_COMPLETED,
                    'title' => 'Layanan Selesai',
                    'message' => 'Buyer telah menyetujui hasil pekerjaan. Layanan selesai.',
                    'visible_to_buyer' => true,
                    'visible_to_seller' => true,
                    'created_at' => now(),
                ]);
            }

            $this->notificationService->serviceCompleted($proposal);
        });

        return back()->with('success', 'Layanan selesai! Terima kasih telah menggunakan layanan ini.');
    }

    /**
     * Cancel service proposal (only if not yet started)
     */
    public function cancelService(Request $request, ServiceProposal $proposal)
    {
        $this->authorizeBuyerForProposal($proposal);

        if (!in_array($proposal->status, [ServiceProposal::STATUS_PENDING, ServiceProposal::STATUS_ACCEPTED])) {
            return back()->with('error', 'Layanan tidak dapat dibatalkan setelah pengerjaan dimulai.');
        }

        $validated = $request->validate([
            'cancel_reason' => 'required|string|min:10|max:1000',
        ]);

        DB::transaction(function () use ($proposal, $validated) {
            $proposal->update([
                'status' => ServiceProposal::STATUS_CANCELLED,
                'cancelled_at' => now(),
            ]);

            if ($proposal->order) {
                $proposal->order->update([
                    'service_status' => 'cancelled',
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                    'cancellation_reason' => $validated['cancel_reason'],
                ]);
            }

            $this->notificationService->serviceCancelled($proposal, $validated['cancel_reason'], true);
        });

        return back()->with('success', 'Layanan dibatalkan.');
    }

    /**
     * Authorize that current user is the buyer of the order
     */
    protected function authorizeBuyer(Order $order): void
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }
    }

    /**
     * Authorize that current user is the buyer for this extension's order
     */
    protected function authorizeBuyerForExtension(ServiceExtension $extension): void
    {
        if ($extension->order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke permintaan ini.');
        }
    }

    /**
     * Authorize that current user is the buyer for this proposal
     */
    protected function authorizeBuyerForProposal(ServiceProposal $proposal): void
    {
        if ($proposal->buyer_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }
    }
}
