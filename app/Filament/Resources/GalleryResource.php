<?php

namespace App\Filament\Resources;

use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\GalleryResource\Pages;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = "heroicon-o-photo";

    protected static ?string $navigationLabel = "Galeri Foto";

    protected static ?string $navigationGroup = "Konten";

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("judul")
                ->maxLength(255)
                ->label("Judul Foto"),

            Forms\Components\FileUpload::make("url_foto")
                ->required()
                ->image()
                ->directory("gallery")
                ->label("Upload Foto")
                ->helperText("Ukuran optimal: 1200x800 px"),

            Forms\Components\Textarea::make("deskripsi")
                ->maxLength(65535)
                ->columnSpanFull()
                ->label("Deskripsi"),

            Forms\Components\Select::make("lokasi")
                ->options([
                    "Makkah" => "Makkah",
                    "Madinah" => "Madinah",
                    "Jeddah" => "Jeddah",
                    "Lainnya" => "Lainnya",
                ])
                ->label("Lokasi"),

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
                Tables\Columns\ImageColumn::make("url_foto")
                    ->label("Foto")
                    ->square()
                    ->size(80),

                Tables\Columns\TextColumn::make("judul")
                    ->searchable()
                    ->label("Judul"),

                Tables\Columns\TextColumn::make("lokasi")
                    ->searchable()
                    ->badge()
                    ->color(
                        fn($state) => match ($state) {
                            "Makkah" => "success",
                            "Madinah" => "info",
                            default => "gray",
                        },
                    )
                    ->label("Lokasi"),

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

                Tables\Filters\SelectFilter::make("lokasi")
                    ->options([
                        "Makkah" => "Makkah",
                        "Madinah" => "Madinah",
                        "Jeddah" => "Jeddah",
                        "Lainnya" => "Lainnya",
                    ])
                    ->label("Lokasi"),
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
            "index" => Pages\ListGalleries::route("/"),
            "create" => Pages\CreateGallery::route("/create"),
            "edit" => Pages\EditGallery::route("/{record}/edit"),
        ];
    }
}
