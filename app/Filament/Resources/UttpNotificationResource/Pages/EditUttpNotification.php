<?php

namespace App\Filament\Resources\UttpNotificationResource\Pages;

use App\Filament\Resources\UttpNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUttpNotification extends EditRecord
{
    protected static string $resource = UttpNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
