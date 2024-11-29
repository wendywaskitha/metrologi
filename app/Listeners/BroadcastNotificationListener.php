<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification as FilamentNotification;

class BroadcastNotificationListener
{
    public function handle(NotificationSent $event)
    {
        if ($event->notification instanceof \App\Notifications\UttpExpirationNotification) {
            try {
                // Ambil data dari database notification
                $databaseNotification = $event->notifiable->notifications()
                    ->where('type', get_class($event->notification))
                    ->latest()
                    ->first();

                if ($databaseNotification) {
                    $message = $databaseNotification->data['message'] ?? 'Anda memiliki notifikasi baru';
                    $type = $databaseNotification->data['type'] ?? 'warning';

                    // Buat Filament Notification
                    $filamentNotification = FilamentNotification::make()
                        ->title('Notifikasi UTTP')
                        ->body($message)
                        ->icon('heroicon-o-bell-alert')
                        ->color($type === 'expired' ? 'danger' : 'warning')
                        ->persistent()
                        ->actions([
                            \Filament\Notifications\Actions\Action::make('view_details')
                                ->label('Lihat Detail')
                                ->url(route('filament.admin.resources.uttp-expiration-notifications.index'))
                        ]);

                    // Kirim notifikasi Filament
                    auth()->user()?->notify($filamentNotification);
                }
            } catch (\Exception $e) {
                Log::error('Broadcast Notification Error', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }
    }
}
