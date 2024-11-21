<?php

namespace App\Filament\Resources\JenisUttpResource\Pages;

use App\Filament\Resources\JenisUttpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisUttp extends EditRecord
{
    protected static string $resource = JenisUttpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
