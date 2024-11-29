<?php

namespace App\Filament\Resources\WajibTeraPasarResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UttpHistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'uttpHistories';

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\TextInput::make('jenisUttp.name')
    //                 ->required()
    //                 ->maxLength(255),
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('jenisUttp.name')
            ->columns([
                Tables\Columns\TextColumn::make('jenisUttp.name')
                    ->label('Jenis UTTP'),
                Tables\Columns\TextColumn::make('merk')
                    ->label('Merek'),
                Tables\Columns\TextColumn::make('kap_max')
                    ->label('Kapasitas Maksimum')
                    ->formatStateUsing(fn($state) => number_format($state, 0, ',', '.')),
                Tables\Columns\TextColumn::make('satuan.name')
                    ->label('Satuan'),
                Tables\Columns\TextColumn::make('tgl_uji')
                    ->label('Tanggal Uji')
                    ->date(),
                Tables\Columns\TextColumn::make('expired')
                    ->label('Tanggal Expired')
                    ->date(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'sah',
                        'warning' => 'batal',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'sah' => 'Sah',
                        'batal' => 'Batal',
                    ]),
                Tables\Filters\SelectFilter::make('jenis_uttp_id')
                    ->relationship('jenisUttp', 'name')
                    ->label('Jenis UTTP'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\ViewAction::make()
                //     ->modalContent(function($record) {
                //         return view('filament.resources.wajib-tera-pasar.history-details', [
                //             'record' => $record
                //         ]);
                //     }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }


}
