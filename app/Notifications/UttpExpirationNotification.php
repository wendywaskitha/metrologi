<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Support\Facades\Route;

class UttpExpirationNotification extends Notification
{
    protected $uttps;
    protected $type;

    public function __construct($uttps, $type = 'warning')
    {
        $this->uttps = collect($uttps);
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database', 'filament'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Notifikasi UTTP',
            'body' => $this->getMessage(), // Ganti dengan method getMessage()
            'type' => $this->type,
            'details' => $this->uttps->map(function($uttp) {
                return [
                    'jenis_uttp' => optional($uttp->jenisUttp)->name,
                    'pemilik' => optional($uttp->wajibTeraPasar)->name,
                    'expired_date' => $uttp->expired ? $uttp->expired->format('d-m-Y') : null
                ];
            })->toArray()
        ];
    }

    public function toFilament($notifiable)
    {
        $message = $this->getMessage(); // Ganti dengan method getMessage()
        $color = $this->type === 'expired' ? 'danger' : 'warning';

        // Gunakan route dinamis atau fallback ke halaman default
        $viewUrl = rescue(function() {
            return route('filament.admin.resources.uttp-notifications.index');
        }, '/admin');

        return FilamentNotification::make()
            ->title('Notifikasi UTTP')
            ->body($message)
            ->icon('heroicon-o-bell-alert')
            ->color($color)
            ->actions([
                \Filament\Notifications\Actions\Action::make('view')
                    ->label('Lihat Detail')
                    ->url(fn() => $viewUrl)
            ])
            ->persistent();
    }

    // Ganti nama method dari generateMessage() ke getMessage()
    protected function getMessage()
    {
        $count = $this->uttps->count();
        $firstUttp = $this->uttps->first();

        $jenisUttp = optional($firstUttp->jenisUttp)->name ?? 'UTTP';

        if ($this->type === 'expired') {
            return $count > 1
                ? "Terdapat {$count} UTTP {$jenisUttp} telah EXPIRED"
                : "UTTP {$jenisUttp} telah EXPIRED";
        } else {
            return $count > 1
                ? "Terdapat {$count} UTTP {$jenisUttp} akan segera EXPIRED"
                : "UTTP {$jenisUttp} akan segera EXPIRED";
        }
    }
}
