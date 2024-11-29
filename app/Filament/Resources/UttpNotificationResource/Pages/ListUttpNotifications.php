<?php

namespace App\Filament\Resources\UttpNotificationResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\UttpNotificationResource;

class ListUttpNotifications extends ListRecords
{
    protected static string $resource = UttpNotificationResource::class;

    // Opsional: Tambahkan header actions jika diperlukan
    protected function getHeaderActions(): array
    {
        return [
            Action::make('markAllAsRead')
                ->label('Tandai Semua Dibaca')
                ->color('primary')
                ->action(function () {
                    // Gunakan update langsung pada query
                    auth()->user()->unreadNotifications()
                        ->where('type', 'App\Notifications\UttpExpirationNotification')
                        ->update(['read_at' => now()]);
                }),
        ];
    }
}
