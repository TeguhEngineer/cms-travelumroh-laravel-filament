<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrustBarResource\Pages;
use App\Models\TrustBar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrustBarResource extends Resource
{
    protected static ?string $model = TrustBar::class;

    protected static ?string $navigationIcon = "heroicon-o-check-badge";

    protected static ?string $navigationLabel = "Trust Bar (Bawah Cover)";

    protected static ?string $navigationGroup = "Konten";

    protected static ?int $navigationSort = 24;

    protected static ?string $modelLabel = "Trust Bar";

    protected static ?string $pluralModelLabel = "Trust Bar";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("judul")
                ->required()
                ->maxLength(255)
                ->label("Judul")
                ->helperText("Contoh: SK Kemenag RI"),

            Forms\Components\TextInput::make("deskripsi")
                ->maxLength(255)
                ->label("Deskripsi (opsional)")
                ->helperText("Contoh: No. D/123/2020"),

            Forms\Components\Select::make("ikon")
                ->options([
                    "shield" => "Shield (Perisai)",
                    "award" => "Award (Penghargaan)",
                    "building" => "Building (Gedung)",
                    "users" => "Users (Jamaah)",
                    "badge-check" => "Badge Check (Terverifikasi)",
                    "handshake" => "Handshake (Kerja Sama)",
                    "star" => "Star (Bintang)",
                    "plane" => "Plane (Pesawat)",
                    "globe" => "Globe (Dunia)",
                    "heart-handshake" => "Heart Handshake (Layanan)",
                ])
                ->default("shield")
                ->label("Ikon")
                ->helperText("Ikon yang tampil di samping teks."),

            Forms\Components\TextInput::make("urutan")
                ->numeric()
                ->default(0)
                ->label("Urutan")
                ->helperText("Angka kecil tampil lebih dulu."),

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
                Tables\Columns\TextColumn::make("urutan")
                    ->sortable()
                    ->label("Urutan"),

                Tables\Columns\TextColumn::make("judul")
                    ->searchable()
                    ->label("Judul"),

                Tables\Columns\TextColumn::make("deskripsi")
                    ->limit(40)
                    ->label("Deskripsi"),

                Tables\Columns\TextColumn::make("ikon")
                    ->badge()
                    ->label("Ikon"),

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
            ->defaultSort("urutan", "asc");
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListTrustBars::route("/"),
            "create" => Pages\CreateTrustBar::route("/create"),
            "edit" => Pages\EditTrustBar::route("/{record}/edit"),
        ];
    }
}
