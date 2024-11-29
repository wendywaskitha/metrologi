<?php

namespace App\Filament\Resources\UttpExpirationNotificationResource\Pages;

use App\Filament\Resources\UttpExpirationNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUttpExpirationNotification extends EditRecord
{
    protected static string $resource = UttpExpirationNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
