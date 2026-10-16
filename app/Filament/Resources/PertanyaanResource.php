<?php

namespace App\Filament\Resources;

use App\Models\Pertanyaan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\PertanyaanResource\Pages;

class PertanyaanResource extends Resource
{
    protected static ?string $model = Pertanyaan::class;

    protected static ?string $navigationIcon = "heroicon-o-question-mark-circle";

    protected static ?string $navigationLabel = "FAQ (Pertanyaan)";

    protected static ?string $navigationGroup = "Konten";

    protected static ?int $navigationSort = 23;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Textarea::make("pertanyaan")
                ->required()
                ->maxLength(65535)
                ->columnSpanFull()
                ->label("Pertanyaan"),

            Forms\Components\Textarea::make("jawaban")
                ->required()
                ->maxLength(65535)
                ->columnSpanFull()
                ->label("Jawaban"),

            Forms\Components\TextInput::make("kategori")
                ->maxLength(100)
                ->label("Kategori (opsional)")
                ->helperText("Contoh: Umroh, Haji, Pembayaran, dll"),

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
                Tables\Columns\TextColumn::make("pertanyaan")
                    ->searchable()
                    ->limit(50)
                    ->label("Pertanyaan"),

                Tables\Columns\TextColumn::make("kategori")
                    ->searchable()
                    ->badge()
                    ->label("Kategori"),

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

                Tables\Filters\SelectFilter::make("kategori")->label(
                    "Kategori",
                ),
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
            "index" => Pages\ListPertanyaans::route("/"),
            "create" => Pages\CreatePertanyaan::route("/create"),
            "edit" => Pages\EditPertanyaan::route("/{record}/edit"),
        ];
    }
}
