<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\ServiceExtension;
use App\Models\ServiceProposal;
use App\Models\User;

class OrderNotificationService
{
    /**
     * Notify when buyer creates a service proposal
     */
    public function proposalCreated(ServiceProposal $proposal): void
    {
        // Notify seller
        $this->createNotification(
            $proposal->seller_id,
            'Proposal Layanan Baru 📋',
            "Anda menerima proposal baru untuk layanan \"{$proposal->product->name}\" dari {$proposal->buyer->name}.",
            'service_proposal',
            ['proposal_id' => $proposal->id, 'order_id' => $proposal->order_id]
        );

        // Log event
        if ($proposal->order_id) {
            OrderEvent::record(
                $proposal->order_id,
                OrderEvent::TYPE_PROPOSAL_CREATED,
                'Proposal dibuat',
                OrderEvent::ACTOR_BUYER,
                $proposal->buyer_id,
                "Proposal layanan diajukan dengan harga Rp" . number_format($proposal->proposed_price, 0, ',', '.') . " dan deadline " . $proposal->proposed_deadline->format('d M Y'),
                [
                    'proposed_price' => $proposal->proposed_price,
                    'proposed_deadline' => $proposal->proposed_deadline->toDateString(),
                    'description' => $proposal->description,
                ],
                serviceProposalId: $proposal->id
            );
        }
    }

    /**
     * Notify when seller accepts a proposal
     */
    public function proposalAccepted(ServiceProposal $proposal): void
    {
        // Notify buyer
        $this->createNotification(
            $proposal->buyer_id,
            'Proposal Diterima ✅',
            "Seller {$proposal->seller->name} menerima proposal Anda untuk \"{$proposal->product->name}\". Pekerjaan akan segera dimulai.",
            'service_proposal_accepted',
            ['proposal_id' => $proposal->id, 'order_id' => $proposal->order_id]
        );

        // Log event
        if ($proposal->order_id) {
            OrderEvent::record(
                $proposal->order_id,
                OrderEvent::TYPE_PROPOSAL_ACCEPTED,
                'Proposal diterima',
                OrderEvent::ACTOR_SELLER,
                $proposal->seller_id,
                "Seller menerima proposal dengan harga Rp" . number_format($proposal->getFinalPrice(), 0, ',', '.'),
                [
                    'agreed_price' => $proposal->agreed_price,
                    'agreed_deadline' => $proposal->agreed_deadline?->toDateString(),
                ],
                serviceProposalId: $proposal->id
            );
        }
    }

    /**
     * Notify when seller rejects a proposal
     */
    public function proposalRejected(ServiceProposal $proposal, ?string $reason = null): void
    {
        // Notify buyer
        $message = "Maaf, proposal Anda untuk \"{$proposal->product->name}\" tidak diterima oleh seller.";
        if ($reason) {
            $message .= " Alasan: {$reason}";
        }

        $this->createNotification(
            $proposal->buyer_id,
            'Proposal Ditolak ❌',
            $message,
            'service_proposal_rejected',
            ['proposal_id' => $proposal->id, 'order_id' => $proposal->order_id]
        );

        // Log event
        if ($proposal->order_id) {
            OrderEvent::record(
                $proposal->order_id,
                OrderEvent::TYPE_PROPOSAL_REJECTED,
                'Proposal ditolak',
                OrderEvent::ACTOR_SELLER,
                $proposal->seller_id,
                $reason ?? 'Proposal ditolak oleh seller',
                ['rejection_reason' => $reason],
                serviceProposalId: $proposal->id
            );
        }
    }

    /**
     * Notify when seller starts work
     */
    public function workStarted(ServiceProposal $proposal): void
    {
        // Notify buyer
        $this->createNotification(
            $proposal->buyer_id,
            'Pekerjaan Dimulai 🔨',
            "Seller mulai mengerjakan layanan \"{$proposal->product->name}\". Target selesai: " . $proposal->getFinalDeadline()->format('d M Y'),
            'service_work_started',
            ['proposal_id' => $proposal->id, 'order_id' => $proposal->order_id]
        );

        // Log event
        if ($proposal->order_id) {
            OrderEvent::record(
                $proposal->order_id,
                OrderEvent::TYPE_WORK_STARTED,
                'Pengerjaan dimulai',
                OrderEvent::ACTOR_SELLER,
                $proposal->seller_id,
                "Seller memulai pengerjaan. Deadline: " . $proposal->getFinalDeadline()->format('d M Y'),
                ['started_at' => now()->toIso8601String()],
                serviceProposalId: $proposal->id
            );
        }
    }

    /**
     * Notify when seller submits work for review
     */
    public function reviewSubmitted(ServiceProposal $proposal, ?string $notes = null): void
    {
        // Notify buyer
        $message = "Seller telah menyelesaikan pekerjaan untuk \"{$proposal->product->name}\". Silakan review dan berikan feedback.";
        
        $this->createNotification(
            $proposal->buyer_id,
            'Pekerjaan Selesai, Mohon Review 📝',
            $message,
            'service_review_submitted',
            ['proposal_id' => $proposal->id, 'order_id' => $proposal->order_id]
        );

        // Log event
        if ($proposal->order_id) {
            OrderEvent::record(
                $proposal->order_id,
                OrderEvent::TYPE_REVIEW_SUBMITTED,
                'Hasil dikirim untuk review',
                OrderEvent::ACTOR_SELLER,
                $proposal->seller_id,
                $notes ?? 'Seller mengirimkan hasil pekerjaan untuk direview',
                ['submitted_at' => now()->toIso8601String(), 'notes' => $notes],
                serviceProposalId: $proposal->id
            );
        }
    }

    /**
     * Notify when buyer requests revision
     */
    public function revisionRequested(ServiceProposal $proposal, string $feedback): void
    {
        // Notify seller
        $this->createNotification(
            $proposal->seller_id,
            'Revisi Diminta 🔄',
            "Buyer meminta revisi untuk layanan \"{$proposal->product->name}\". Feedback: " . substr($feedback, 0, 100) . (strlen($feedback) > 100 ? '...' : ''),
            'service_revision_requested',
            ['proposal_id' => $proposal->id, 'order_id' => $proposal->order_id]
        );

        // Log event
        if ($proposal->order_id) {
            OrderEvent::record(
                $proposal->order_id,
                OrderEvent::TYPE_REVISION_REQUESTED,
                'Revisi diminta',
                OrderEvent::ACTOR_BUYER,
                $proposal->buyer_id,
                $feedback,
                ['feedback' => $feedback],
                serviceProposalId: $proposal->id
            );
        }
    }

    /**
     * Notify when buyer approves and completes the service
     */
    public function serviceCompleted(ServiceProposal $proposal): void
    {
        // Notify seller
        $this->createNotification(
            $proposal->seller_id,
            'Layanan Selesai ✅',
            "Buyer telah menyetujui hasil pekerjaan untuk \"{$proposal->product->name}\". Terima kasih!",
            'service_completed',
            ['proposal_id' => $proposal->id, 'order_id' => $proposal->order_id]
        );

        // Log event
        if ($proposal->order_id) {
            OrderEvent::record(
                $proposal->order_id,
                OrderEvent::TYPE_COMPLETED,
                'Layanan selesai',
                OrderEvent::ACTOR_BUYER,
                $proposal->buyer_id,
                'Buyer menyetujui hasil pekerjaan dan menyelesaikan pesanan',
                ['completed_at' => now()->toIso8601String()],
                serviceProposalId: $proposal->id
            );
        }
    }

    /**
     * Notify when seller requests an extension
     */
    public function extensionRequested(ServiceExtension $extension): void
    {
        $order = $extension->order;
        $requester = $extension->requester;

        // Notify buyer
        $this->createNotification(
            $order->user_id,
            'Permintaan Perpanjangan Waktu ⏰',
            "Seller meminta perpanjangan waktu {$extension->extension_days} hari untuk pesanan Anda. Alasan: " . substr($extension->reason, 0, 100),
            'extension_requested',
            ['extension_id' => $extension->id, 'order_id' => $order->id]
        );

        // Log event
        OrderEvent::record(
            $order->id,
            OrderEvent::TYPE_EXTENSION_REQUESTED,
            'Perpanjangan waktu diminta',
            OrderEvent::ACTOR_SELLER,
            $requester->id,
            $extension->reason,
            [
                'extension_days' => $extension->extension_days,
                'original_deadline' => $extension->original_deadline->toDateString(),
                'new_deadline' => $extension->new_deadline->toDateString(),
                'auto_approve_at' => $extension->auto_approve_at->toIso8601String(),
            ]
        );
    }

    /**
     * Notify when buyer approves extension
     */
    public function extensionApproved(ServiceExtension $extension): void
    {
        $order = $extension->order;

        // Notify seller
        $this->createNotification(
            $extension->requested_by,
            'Perpanjangan Disetujui ✅',
            "Buyer menyetujui perpanjangan waktu. Deadline baru: " . $extension->new_deadline->format('d M Y'),
            'extension_approved',
            ['extension_id' => $extension->id, 'order_id' => $order->id]
        );

        // Log event
        OrderEvent::record(
            $order->id,
            OrderEvent::TYPE_EXTENSION_APPROVED,
            'Perpanjangan disetujui',
            OrderEvent::ACTOR_BUYER,
            $extension->responded_by,
            $extension->response_message ?? 'Buyer menyetujui perpanjangan waktu',
            [
                'extension_days' => $extension->extension_days,
                'new_deadline' => $extension->new_deadline->toDateString(),
            ]
        );
    }

    /**
     * Notify when buyer rejects extension
     */
    public function extensionRejected(ServiceExtension $extension): void
    {
        $order = $extension->order;

        // Notify seller
        $message = "Buyer menolak permintaan perpanjangan waktu.";
        if ($extension->response_message) {
            $message .= " Pesan: " . $extension->response_message;
        }

        $this->createNotification(
            $extension->requested_by,
            'Perpanjangan Ditolak ❌',
            $message,
            'extension_rejected',
            ['extension_id' => $extension->id, 'order_id' => $order->id]
        );

        // Log event
        OrderEvent::record(
            $order->id,
            OrderEvent::TYPE_EXTENSION_REJECTED,
            'Perpanjangan ditolak',
            OrderEvent::ACTOR_BUYER,
            $extension->responded_by,
            $extension->response_message ?? 'Buyer menolak perpanjangan waktu',
            ['reason' => $extension->response_message]
        );
    }

    /**
     * Notify when extension is auto-approved
     */
    public function extensionAutoApproved(ServiceExtension $extension): void
    {
        $order = $extension->order;

        // Notify both parties
        $this->createNotification(
            $order->user_id,
            'Perpanjangan Disetujui Otomatis ⏰',
            "Permintaan perpanjangan untuk pesanan #{$order->order_number} telah disetujui otomatis karena tidak ada respons dalam 24 jam. Deadline baru: " . $extension->new_deadline->format('d M Y'),
            'extension_auto_approved',
            ['extension_id' => $extension->id, 'order_id' => $order->id]
        );

        $this->createNotification(
            $extension->requested_by,
            'Perpanjangan Disetujui Otomatis ⏰',
            "Permintaan perpanjangan Anda telah disetujui otomatis. Deadline baru: " . $extension->new_deadline->format('d M Y'),
            'extension_auto_approved',
            ['extension_id' => $extension->id, 'order_id' => $order->id]
        );

        // Log event
        OrderEvent::record(
            $order->id,
            OrderEvent::TYPE_EXTENSION_AUTO_APPROVED,
            'Perpanjangan disetujui otomatis',
            OrderEvent::ACTOR_SYSTEM,
            null,
            'Perpanjangan waktu disetujui otomatis setelah 24 jam tanpa respons',
            [
                'extension_days' => $extension->extension_days,
                'new_deadline' => $extension->new_deadline->toDateString(),
            ]
        );
    }

    /**
     * Notify when service order is cancelled
     */
    public function serviceCancelled(ServiceProposal $proposal, string $reason, bool $byBuyer = true): void
    {
        $targetUserId = $byBuyer ? $proposal->seller_id : $proposal->buyer_id;
        $actor = $byBuyer ? 'Buyer' : 'Seller';

        $this->createNotification(
            $targetUserId,
            'Pesanan Layanan Dibatalkan ❌',
            "{$actor} membatalkan pesanan layanan \"{$proposal->product->name}\". Alasan: {$reason}",
            'service_cancelled',
            ['proposal_id' => $proposal->id, 'order_id' => $proposal->order_id]
        );

        // Log event
        if ($proposal->order_id) {
            OrderEvent::record(
                $proposal->order_id,
                OrderEvent::TYPE_CANCELLED,
                'Pesanan dibatalkan',
                $byBuyer ? OrderEvent::ACTOR_BUYER : OrderEvent::ACTOR_SELLER,
                $byBuyer ? $proposal->buyer_id : $proposal->seller_id,
                $reason,
                ['cancelled_by' => $actor, 'reason' => $reason],
                serviceProposalId: $proposal->id
            );
        }
    }

    /**
     * Create a notification record
     */
    protected function createNotification(
        int $userId,
        string $title,
        string $message,
        string $type,
        array $data = []
    ): Notification {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
        ]);
    }
}
