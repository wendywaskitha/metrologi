<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UttpNotificationResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Notifications\DatabaseNotification;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use App\Models\User;

class UttpNotificationResource extends Resource
{
    protected static ?string $model = DatabaseNotification::class;
    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?string $navigationLabel = 'Notifikasi UTTP';
    protected static ?string $slug = 'uttp-notifications';

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) =>
                $query->where('type', 'App\Notifications\UttpExpirationNotification')
                      ->where('notifiable_type', User::class)
                      ->whereHas('notifiable', fn($q) => $q->role('super_admin'))
                      ->latest()
            )
            ->columns([
                TextColumn::make('data.title')
                    ->label('Judul')
                    ->badge()
                    ->color(Color::Blue),
                TextColumn::make('data.body')
                    ->label('Pesan')
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('markAsRead')
                    ->label('Tandai Dibaca')
                    ->action(function (DatabaseNotification $record) {
                        // Update read_at secara langsung
                        $record->update(['read_at' => now()]);
                    })
                    ->visible(fn(DatabaseNotification $record) => is_null($record->read_at)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markAsRead')
                        ->label('Tandai Semua Dibaca')
                        ->action(function ($records) {
                            // Update read_at untuk semua record
                            $records->each(function ($record) {
                                $record->update(['read_at' => now()]);
                            });
                        }),
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUttpNotifications::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return auth()->user()?->unreadNotifications()
            ->where('type', 'App\Notifications\UttpExpirationNotification')
            ->count() ?: null;
    }
}
