<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FasilitasResource\Pages;
use App\Filament\Resources\FasilitasResource\RelationManagers;
use App\Models\Fasilitas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FasilitasResource extends Resource
{
    protected static ?string $model = Fasilitas::class;

    protected static ?string $navigationIcon = "heroicon-o-sparkles";

    protected static ?string $navigationLabel = "Fasilitas";

    protected static ?string $navigationGroup = "Data Master";

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("nama_fasilitas")
                ->required()
                ->maxLength(255)
                ->label("Nama Fasilitas"),

            Forms\Components\Select::make("kategori")
                ->required()
                ->options([
                    "umroh" => "Umroh",
                    "haji" => "Haji",
                    "umum" => "Umum",
                ])
                ->default("umum")
                ->label("Kategori Paket"),

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
                Tables\Columns\TextColumn::make("nama_fasilitas")
                    ->searchable()
                    ->label("Nama Fasilitas"),

                Tables\Columns\TextColumn::make("kategori")
                    ->badge()
                    ->color(
                        fn($state) => match ($state) {
                            "umroh" => "success",
                            "haji" => "warning",
                            "umum" => "info",
                            default => "gray",
                        },
                    )
                    ->formatStateUsing(
                        fn($state) => match ($state) {
                            "umroh" => "Umroh",
                            "haji" => "Haji",
                            "umum" => "Umum",
                            default => $state,
                        },
                    )
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
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListFasilitas::route("/"),
            "create" => Pages\CreateFasilitas::route("/create"),
            "edit" => Pages\EditFasilitas::route("/{record}/edit"),
        ];
    }
}
