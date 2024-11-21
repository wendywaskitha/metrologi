<?php

namespace App\Filament\Resources\WajibTeraPasarResource\Pages;

use App\Filament\Resources\WajibTeraPasarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWajibTeraPasar extends EditRecord
{
    protected static string $resource = WajibTeraPasarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
