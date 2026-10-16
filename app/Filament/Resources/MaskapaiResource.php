<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaskapaiResource\Pages;
use App\Models\Maskapai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MaskapaiResource extends Resource
{
    protected static ?string $model = Maskapai::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationLabel = 'Maskapai';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_maskapai')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Maskapai'),

                Forms\Components\Textarea::make('keterangan')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->label('Keterangan'),

                Forms\Components\Toggle::make('aktif')
                    ->required()
                    ->default(true)
                    ->label('Aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_maskapai')
                    ->searchable()
                    ->label('Nama Maskapai'),

                Tables\Columns\TextColumn::make('keterangan')
                    ->limit(50)
                    ->label('Keterangan'),

                Tables\Columns\IconColumn::make('aktif')
                    ->boolean()
                    ->label('Status'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaskapais::route('/'),
            'create' => Pages\CreateMaskapai::route('/create'),
            'edit' => Pages\EditMaskapai::route('/{record}/edit'),
        ];
    }
}
