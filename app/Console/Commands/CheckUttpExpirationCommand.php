<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UttpExpirationNotificationService;
use Illuminate\Support\Facades\Log;

class CheckUttpExpirationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uttp:check-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check UTTP expiration and create notifications';

    /**
     * Execute the console command.
     */
    public function handle(UttpExpirationNotificationService $service)
    {
        try {
            $count = $service->checkAndCreateExpirationNotifications();

            Log::info("UTTP Expiration Check: Created {$count} notifications");

            $this->info("Created {$count} expiration notifications.");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            Log::error('UTTP Expiration Check Failed: ' . $e->getMessage());

            $this->error('Expiration check failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
