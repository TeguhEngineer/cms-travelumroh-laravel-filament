<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembimbingResource\Pages;
use App\Models\Pembimbing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PembimbingResource extends Resource
{
    protected static ?string $model = Pembimbing::class;

    protected static ?string $navigationIcon = "heroicon-o-user-group";

    protected static ?string $navigationLabel = "Pembimbing";

    protected static ?string $navigationGroup = "Data Master";

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("nama_pembimbing")
                ->required()
                ->maxLength(255)
                ->label("Nama Pembimbing"),

            Forms\Components\Select::make("kategori")
                ->required()
                ->options([
                    "tour-leader" => "Tour Leader",
                    "muthawwif" => "Muthawwif",
                ])
                ->label("Kategori"),

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
                Tables\Columns\TextColumn::make("nama_pembimbing")
                    ->searchable()
                    ->label("Nama Pembimbing"),

                Tables\Columns\TextColumn::make("kategori")
                    ->badge()
                    ->color(
                        fn($state) => match ($state) {
                            "tour-leader" => "success",
                            "muthawwif" => "info",
                            default => "gray",
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

                Tables\Filters\SelectFilter::make("kategori")
                    ->options([
                        "tour-leader" => "Tour Leader",
                        "muthawwif" => "Muthawwif",
                    ])
                    ->label("Kategori"),
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
            "index" => Pages\ListPembimbings::route("/"),
            "create" => Pages\CreatePembimbing::route("/create"),
            "edit" => Pages\EditPembimbing::route("/{record}/edit"),
        ];
    }
}
