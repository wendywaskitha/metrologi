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

    protected static ?string $title = 'UTTP';

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
                Tables\Columns\TextColumn::make('tgl_uji')->date('d-m-Y'),
                Tables\Columns\TextColumn::make('expired')
                    ->label('Tanggal Berlaku')
                    ->formatStateUsing(function ($record) {
                        $expiredDate = \Carbon\Carbon::parse($record->expired);
                        $now = \Carbon\Carbon::now();
                        $nextYear = $now->copy()->addYear();
                        $oneMonthBeforeNextYear = $nextYear->copy()->subMonth();

                        // Determine the color based on the expiration date
                        if ($expiredDate->isToday()) {
                            return '<span style="color: red;">' . $expiredDate->format('d-m-Y') . '</span>';
                        } elseif ($expiredDate->between($oneMonthBeforeNextYear, $nextYear)) {
                            // If the expired date is within 1 month of next year
                            return '<span style="color: orange;">' . $expiredDate->format('d-m-Y') . '</span>';
                        }

                        return $expiredDate->format('d-m-Y'); // Default format
                    })
                    ->html(), // Enable HTML rendering
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'sah',
                        'warning' => 'batal',
                    ]),
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
