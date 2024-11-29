<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UttpExpirationNotificationService;
use Illuminate\Support\Facades\Log;

class CheckUttpExpirationCommand extends Command
{
    protected $signature = 'uttp:check-expiration';
    protected $description = 'Check UTTP expiration and create notifications';

    public function __construct(
        protected UttpExpirationNotificationService $notificationService
    ) {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $count = $this->notificationService->checkAndCreateExpirationNotifications();

            Log::info("UTTP Expiration Check: Sent {$count} notifications");
            $this->info("Sent {$count} expiration notifications to super admin.");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            Log::error('UTTP Expiration Check Failed: ' . $e->getMessage());
            $this->error('Expiration check failed: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
