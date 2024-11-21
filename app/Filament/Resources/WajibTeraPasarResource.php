<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Barryvdh\DomPDF\PDF;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\WajibTeraPasar;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WajibTeraPasarResource\Pages;
use App\Filament\Resources\WajibTeraPasarResource\RelationManagers;
use App\Filament\Resources\WajibTeraPasarResource\RelationManagers\JenisUttpRelationManager;
use App\Filament\Resources\WajibTeraPasarResource\RelationManagers\UttpWajibTeraPasarRelationManager;

class WajibTeraPasarResource extends Resource
{
    protected static ?string $model = WajibTeraPasar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Pemilik UTTP')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(255),
                Forms\Components\Select::make('pasar_id')
                    ->relationship('pasar', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Pemilik UTTP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pasar.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('UttpWajibTeraPasar')
                    ->label('UTTP Details')
                    ->sortable()
                    ->formatStateUsing(function ($record) {
                        setlocale(LC_MONETARY, 'id_ID');
                        return '<ul>' . $record->uttpWajibTeraPasar->map(function ($item) {
                            // Format kap_max as a number with Indonesian format without decimal places
                            $kapMaxFormatted = number_format($item->kap_max, 0, '.', '.');
                            $satuanName = $item->satuan->name; // Access the satuan relation to get the unit name
                            return "<li>{$item->jenisUttp->name} | Kap Maks: {$kapMaxFormatted} {$satuanName}, Daya Baca: {$item->daya_baca}</li>";
                        })->implode('') . '</ul>'; // Create a bulleted list
                    })
                    ->html(), // Enable HTML rendering
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UttpWajibTeraPasarRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWajibTeraPasars::route('/'),
            'create' => Pages\CreateWajibTeraPasar::route('/create'),
            'edit' => Pages\EditWajibTeraPasar::route('/{record}/edit'),
        ];
    }
}
