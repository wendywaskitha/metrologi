<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UttpExpirationNotificationResource\Pages;
use App\Models\UttpExpirationNotification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;

class UttpExpirationNotificationResource extends Resource
{
    protected static ?string $model = UttpExpirationNotification::class;
    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?string $navigationLabel = 'Notifikasi UTTP';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('message')
                    ->label('Pesan')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'expired' ? 'danger' : 'warning'),
                TextColumn::make('is_read')
                    ->label('Dibaca')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime(),
            ])
            ->actions([
                Action::make('markAsRead')
                    ->label('Tandai Dibaca')
                    ->action(fn(UttpExpirationNotification $record) => $record->update(['is_read' => true]))
                    ->requiresConfirmation(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUttpExpirationNotifications::route('/'),
        ];
    }
}
