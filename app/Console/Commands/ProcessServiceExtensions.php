<?php

namespace App\Console\Commands;

use App\Models\ServiceExtension;
use App\Services\OrderNotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessServiceExtensions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:process-extensions
                            {--dry-run : Run without actually approving extensions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending service extensions and auto-approve those past 24 hours';

    /**
     * Execute the console command.
     */
    public function handle(OrderNotificationService $notificationService): int
    {
        $this->info('Processing pending service extensions...');

        $extensions = ServiceExtension::readyForAutoApproval()->with(['order', 'requester'])->get();

        if ($extensions->isEmpty()) {
            $this->info('No extensions ready for auto-approval.');
            return Command::SUCCESS;
        }

        $this->info("Found {$extensions->count()} extension(s) ready for auto-approval.");

        $approved = 0;
        $failed = 0;

        foreach ($extensions as $extension) {
            try {
                if ($this->option('dry-run')) {
                    $this->line("  [DRY-RUN] Would auto-approve extension #{$extension->id} for order #{$extension->order_id}");
                    continue;
                }

                // Auto-approve the extension
                $extension->autoApprove();

                // Update order deadline
                $order = $extension->order;
                if ($order) {
                    $order->update([
                        'service_due_at' => $extension->new_deadline,
                    ]);
                }

                // Send notifications
                $notificationService->extensionAutoApproved($extension);

                $this->line("  ✓ Auto-approved extension #{$extension->id} for order #{$extension->order_id}");
                $approved++;

            } catch (\Exception $e) {
                $this->error("  ✗ Failed to process extension #{$extension->id}: {$e->getMessage()}");
                Log::error("Failed to auto-approve extension", [
                    'extension_id' => $extension->id,
                    'order_id' => $extension->order_id,
                    'error' => $e->getMessage(),
                ]);
                $failed++;
            }
        }

        if ($this->option('dry-run')) {
            $this->newLine();
            $this->info("Dry-run complete. {$extensions->count()} extension(s) would be auto-approved.");
        } else {
            $this->newLine();
            $this->info("Processing complete. Approved: {$approved}, Failed: {$failed}");
        }

        return $failed > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
