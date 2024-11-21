<?php

namespace App\Filament\Resources\WajibTeraPasarResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UttpWajibTeraPasarRelationManager extends RelationManager
{
    protected static string $relationship = 'uttpWajibTeraPasar';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('jenis_uttp_id')
                    ->relationship('jenisuttp', 'name')
                    ->required(),
                Forms\Components\TextInput::make('kap_max')
                    ->label('Kapasitas Maksimum')
                    ->required(),
                Forms\Components\Select::make('satuan_id')
                    ->label('Satuan')
                    ->relationship('satuan', 'name')
                    ->required(),
                Forms\Components\TextInput::make('daya_baca')
                    ->label('e'),
                Forms\Components\TextInput::make('merk')
                    ->label('Merek')
                    ->required(),
                Forms\Components\DatePicker::make('tgl_uji')
                    ->label('Tanggal Uji')
                    ->required(),
                Forms\Components\DatePicker::make('expired')
                    ->label('Tanggal Berlaku')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'sah' => 'Sah',
                        'batal' => 'Batal',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('jenisUttp.name'),
                Tables\Columns\TextColumn::make('kap_max'),
                Tables\Columns\TextColumn::make('satuan.name'),
                Tables\Columns\TextColumn::make('daya_baca'),
                Tables\Columns\TextColumn::make('merk'),
                Tables\Columns\TextColumn::make('tgl_uji'),
                Tables\Columns\TextColumn::make('expired'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
