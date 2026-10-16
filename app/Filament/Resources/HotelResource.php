<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelResource\Pages;
use App\Models\Hotel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;

    protected static ?string $navigationIcon = "heroicon-o-building-office-2";

    protected static ?string $navigationLabel = "Hotel";

    protected static ?string $navigationGroup = "Data Master";

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("nama_hotel")
                ->required()
                ->maxLength(255)
                ->label("Nama Hotel"),

            Forms\Components\TextInput::make("lokasi")
                ->required()
                ->maxLength(255)
                ->label("Lokasi"),

            Forms\Components\TextInput::make("rating")
                ->required()
                ->numeric()
                ->default(3)
                ->minValue(1)
                ->maxValue(5)
                ->label("Rating"),

            Forms\Components\Toggle::make("aktif")
                ->required()
                ->default(true)
                ->label("Aktif"),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("nama_hotel")
                    ->searchable()
                    ->label("Nama Hotel"),

                Tables\Columns\TextColumn::make("lokasi")
                    ->searchable()
                    ->label("Lokasi"),

                Tables\Columns\TextColumn::make("rating")
                    ->badge()
                    ->color(
                        fn($state) => match (true) {
                            $state >= 4 => "success",
                            $state >= 3 => "warning",
                            default => "danger",
                        },
                    )
                    ->label("Rating"),

                Tables\Columns\IconColumn::make("aktif")
                    ->boolean()
                    ->label("Status"),

                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make("aktif")
                    ->label("Status")
                    ->placeholder("Semua")
                    ->trueLabel("Aktif")
                    ->falseLabel("Tidak Aktif"),

                Tables\Filters\SelectFilter::make("rating")
                    ->options([
                        5 => "5 Bintang",
                        4 => "4 Bintang",
                        3 => "3 Bintang",
                        2 => "2 Bintang",
                        1 => "1 Bintang",
                    ])
                    ->label("Rating"),
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
            ->defaultSort("created_at", "desc");
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListHotels::route("/"),
            "create" => Pages\CreateHotel::route("/create"),
            "edit" => Pages\EditHotel::route("/{record}/edit"),
        ];
    }
}
