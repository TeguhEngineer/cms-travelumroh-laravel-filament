<?php

namespace App\Filament\Resources;

use App\Models\Paket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Filament\Resources\PaketResource\Pages;

class PaketResource extends Resource
{
    protected static ?string $model = Paket::class;

    protected static ?string $navigationIcon = "heroicon-o-ticket";

    protected static ?string $navigationLabel = "Paket Umroh & Haji";

    protected static ?string $navigationGroup = "Paket";

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make("PaketTabs")
                ->tabs([
                    Forms\Components\Tabs\Tab::make("Info Dasar")
                        ->icon("heroicon-o-information-circle")
                        ->schema([
                            Forms\Components\TextInput::make("name")
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(
                                    fn($state, Forms\Set $set) => $set(
                                        "slug",
                                        Str::slug($state),
                                    ),
                                )
                                ->label("Nama Paket"),

                            Forms\Components\TextInput::make("slug")
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->label("Slug (URL)")
                                ->helperText("Otomatis terisi dari nama"),

                            Forms\Components\Select::make("type")
                                ->required()
                                ->options([
                                    "umrah" => "Umroh",
                                    "haji" => "Haji",
                                ])
                                ->label("Tipe Paket")
                                ->default("umrah"),

                            Forms\Components\FileUpload::make("thumbnail")
                                ->image()
                                ->directory("paket-thumbnails")
                                ->label("Thumbnail"),

                            Forms\Components\RichEditor::make("description")
                                ->required()
                                ->columnSpanFull()
                                ->label("Deskripsi Paket")
                                ->toolbarButtons([
                                    "bold",
                                    "italic",
                                    "underline",
                                    "bulletList",
                                    "orderedList",
                                    "link",
                                    "heading",
                                ]),

                            Forms\Components\TextInput::make(
                                "kota_keberangkatan",
                            )
                                ->maxLength(255)
                                ->label("Kota Keberangkatan")
                                ->helperText(
                                    "Contoh: Jakarta, Surabaya, Medan",
                                ),

                            Forms\Components\TextInput::make("hotel_rating")
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(5)
                                ->label("Rating Hotel (1-5)"),
                        ]),

                    Forms\Components\Tabs\Tab::make("Harga & Jadwal")
                        ->icon("heroicon-o-calendar")
                        ->schema([
                            Forms\Components\TextInput::make("price")
                                ->required()
                                ->numeric()
                                ->prefix("Rp")
                                ->label("Harga Normal"),

                            Forms\Components\TextInput::make("discount_price")
                                ->numeric()
                                ->prefix("Rp")
                                ->label("Harga Diskon")
                                ->helperText("Kosongkan jika tidak ada diskon"),

                            Forms\Components\DatePicker::make(
                                "tanggal_berangkat",
                            )
                                ->required()
                                ->label("Tanggal Berangkat"),

                            Forms\Components\DatePicker::make("tanggal_pulang")
                                ->required()
                                ->label("Tanggal Pulang"),

                            Forms\Components\TextInput::make("durasi_hari")
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->label("Durasi (Hari)")
                                ->helperText("Contoh: 9 untuk paket 9 hari"),

                            Forms\Components\TextInput::make("quota_seat")
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->default(45)
                                ->label("Kuota Seat"),

                            Forms\Components\TextInput::make("sisa_seat")
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->default(45)
                                ->label("Sisa Seat"),
                        ]),

                    Forms\Components\Tabs\Tab::make("Detail & Status")
                        ->icon("heroicon-o-cog-6-tooth")
                        ->schema([
                            Forms\Components\Toggle::make("is_featured")
                                ->label("Featured (Tampilkan di Highlight)")
                                ->default(false),

                            Forms\Components\Toggle::make("is_promo")
                                ->label("Paket Promo")
                                ->default(false),

                            Forms\Components\Toggle::make("aktif")
                                ->required()
                                ->label("Aktif (Publish)")
                                ->default(true),

                            // TODO: Replace with master data selectors via paketDetails
                            // - Fasilitas from fasilitas master
                            // - Maskapai from maskapais master
                            // - Hotel from hotels master
                            // - Pembimbing from pembimbings master
                            // - Perjalanan from perjalanans master
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make("thumbnail")
                    ->label("Thumbnail")
                    ->square()
                    ->size(60),

                Tables\Columns\TextColumn::make("name")
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->label("Nama Paket"),

                Tables\Columns\TextColumn::make("type")
                    ->badge()
                    ->color(
                        fn(string $state): string => match ($state) {
                            "umrah" => "success",
                            "haji" => "warning",
                        },
                    )
                    ->label("Tipe"),

                Tables\Columns\TextColumn::make("price")
                    ->money("IDR")
                    ->sortable()
                    ->label("Harga"),

                Tables\Columns\TextColumn::make("tanggal_berangkat")
                    ->date()
                    ->sortable()
                    ->label("Tgl Berangkat"),

                Tables\Columns\TextColumn::make("sisa_seat")
                    ->numeric()
                    ->sortable()
                    ->label("Sisa Seat"),

                Tables\Columns\IconColumn::make("is_featured")
                    ->boolean()
                    ->label("Featured"),

                Tables\Columns\IconColumn::make("aktif")
                    ->boolean()
                    ->label("Status"),

                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make("type")
                    ->options([
                        "umrah" => "Umroh",
                        "haji" => "Haji",
                    ])
                    ->label("Tipe Paket"),

                Tables\Filters\TernaryFilter::make("aktif")
                    ->label("Status")
                    ->placeholder("Semua")
                    ->trueLabel("Aktif")
                    ->falseLabel("Non-aktif"),

                Tables\Filters\TernaryFilter::make("is_featured")
                    ->label("Featured")
                    ->placeholder("Semua")
                    ->trueLabel("Featured")
                    ->falseLabel("Regular"),
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
            "index" => Pages\ListPakets::route("/"),
            "create" => Pages\CreatePaket::route("/create"),
            "edit" => Pages\EditPaket::route("/{record}/edit"),
        ];
    }
}
