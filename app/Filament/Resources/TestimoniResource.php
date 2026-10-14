<?php

namespace App\Filament\Resources;

use App\Models\Testimoni;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\TestimoniResource\Pages;

class TestimoniResource extends Resource
{
    protected static ?string $model = Testimoni::class;

    protected static ?string $navigationIcon = "heroicon-o-chat-bubble-left-right";

    protected static ?string $navigationLabel = "Testimoni";

    protected static ?string $navigationGroup = "Konten";

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("nama")
                ->required()
                ->maxLength(255)
                ->label("Nama Jamaah"),

            Forms\Components\FileUpload::make("foto")
                ->image()
                ->directory("testimoni-photos")
                ->label("Foto (opsional)"),

            Forms\Components\Textarea::make("isi_testimoni")
                ->required()
                ->maxLength(65535)
                ->columnSpanFull()
                ->label("Isi Testimoni"),

            Forms\Components\Select::make("rating")
                ->required()
                ->options([
                    1 => "1 Bintang",
                    2 => "2 Bintang",
                    3 => "3 Bintang",
                    4 => "4 Bintang",
                    5 => "5 Bintang",
                ])
                ->default(5)
                ->label("Rating"),

            Forms\Components\TextInput::make("paket_diikuti")
                ->maxLength(255)
                ->label("Paket yang Diikuti"),

            Forms\Components\Toggle::make("aktif")
                ->required()
                ->default(true)
                ->label("Aktif"),

            Forms\Components\TextInput::make("urutan")
                ->numeric()
                ->default(0)
                ->label("Urutan Tampil"),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("nama")
                    ->searchable()
                    ->label("Nama"),

                Tables\Columns\ImageColumn::make("foto")
                    ->label("Foto")
                    ->circular(),

                Tables\Columns\TextColumn::make("isi_testimoni")
                    ->limit(50)
                    ->label("Testimoni"),

                Tables\Columns\TextColumn::make("rating")
                    ->badge()
                    ->color(
                        fn($state) => match ($state) {
                            5 => "success",
                            4 => "info",
                            3 => "warning",
                            default => "danger",
                        },
                    )
                    ->label("Rating"),

                Tables\Columns\IconColumn::make("aktif")
                    ->boolean()
                    ->label("Status"),

                Tables\Columns\TextColumn::make("urutan")
                    ->numeric()
                    ->sortable()
                    ->label("Urutan"),
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
            ->defaultSort("urutan", "asc");
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListTestimonis::route("/"),
            "create" => Pages\CreateTestimoni::route("/create"),
            "edit" => Pages\EditTestimoni::route("/{record}/edit"),
        ];
    }
}
