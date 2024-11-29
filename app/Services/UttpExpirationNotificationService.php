<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\UttpWajibTeraPasar;
use App\Models\UttpExpirationNotification;

class UttpExpirationNotificationService
{
    public function checkAndCreateExpirationNotifications()
    {
        $expiringItems = UttpWajibTeraPasar::with(['wajibTeraPasar', 'jenisUttp'])
            ->where('status', 'sah')
            ->get()
            ->filter(function ($uttp) {
                $expiredDate = Carbon::parse($uttp->expired);
                $now = Carbon::now();

                return $expiredDate->lessThanOrEqualTo($now) ||
                       $expiredDate->diffInDays($now) <= 30;
            });

        $notificationCount = 0;
        foreach ($expiringItems as $uttp) {
            if ($this->createExpirationNotification($uttp)) {
                $notificationCount++;
            }
        }

        return $notificationCount;
    }

    protected function createExpirationNotification($uttp)
    {
        $expiredDate = Carbon::parse($uttp->expired);
        $now = Carbon::now();

        $type = $expiredDate->lessThanOrEqualTo($now) ? 'expired' : 'near_expiration';

        $message = $type === 'expired'
            ? "UTTP masa berlaku habis: {$uttp->jenisUttp->name} milik {$uttp->wajibTeraPasar->name}"
            : "UTTP akan habis masa berlaku dalam {$expiredDate->diffInDays($now)} hari: {$uttp->jenisUttp->name} milik {$uttp->wajibTeraPasar->name}";

        // Cek notifikasi duplikat
        $existingNotification = UttpExpirationNotification::where([
            'uttp_id' => $uttp->id,
            'type' => $type,
            'is_read' => false
        ])->first();

        if (!$existingNotification) {
            UttpExpirationNotification::create([
                'uttp_id' => $uttp->id,
                'wajib_tera_pasar_id' => $uttp->wajib_tera_pasar_id,
                'type' => $type,
                'message' => $message,
                'is_read' => false
            ]);

            return true;
        }

        return false;
    }
}
