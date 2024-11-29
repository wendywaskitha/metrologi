<?php

namespace App\Services;

use App\Models\UttpWajibTeraPasar;
use App\Models\User;
use App\Notifications\UttpExpirationNotification;
use Illuminate\Support\Facades\Log;

class UttpExpirationNotificationService
{
    public function checkAndCreateExpirationNotifications()
    {
        try {
            // Ambil semua super admin
            $superAdmins = User::role('super_admin')->get();

            // Query untuk UTTP yang akan expire dalam 30 hari
            $warningUttp = $this->getWarningUttp();

            // Query untuk UTTP yang sudah expire
            $expiredUttp = $this->getExpiredUttp();

            $notificationCount = 0;

            // Kirim notifikasi warning
            if ($warningUttp->isNotEmpty()) {
                $superAdmins->each(function($admin) use ($warningUttp) {
                    $admin->notify(new UttpExpirationNotification($warningUttp, 'warning'));
                });
                $notificationCount += $warningUttp->count();
            }

            // Kirim notifikasi expired
            if ($expiredUttp->isNotEmpty()) {
                $superAdmins->each(function($admin) use ($expiredUttp) {
                    $admin->notify(new UttpExpirationNotification($expiredUttp, 'expired'));
                });
                $notificationCount += $expiredUttp->count();
            }

            Log::info("UTTP Expiration Check: Created {$notificationCount} notifications");

            return $notificationCount;
        } catch (\Exception $e) {
            Log::error('UTTP Expiration Check Failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    protected function getWarningUttp()
    {
        return UttpWajibTeraPasar::where('status', 'sah')
            ->whereDate('expired', '<=', now()->addDays(30))
            ->whereDate('expired', '>', now())
            ->with(['jenisUttp', 'wajibTeraPasar'])
            ->get();
    }

    protected function getExpiredUttp()
    {
        return UttpWajibTeraPasar::where('status', 'sah')
            ->whereDate('expired', '<=', now())
            ->with(['jenisUttp', 'wajibTeraPasar'])
            ->get();
    }
}
