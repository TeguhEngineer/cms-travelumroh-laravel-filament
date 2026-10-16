<?php

namespace App\Filament\Resources;

use App\Models\Paket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaketUmrohResource\Pages;

class PaketUmrohResource extends Resource
{
    protected static ?string $model = Paket::class;

    protected static ?string $navigationIcon = "heroicon-o-ticket";

    protected static ?string $navigationLabel = "Paket Umroh";

    protected static ?string $navigationGroup = "Paket";

    protected static ?int $navigationSort = 11;

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

                            Forms\Components\Hidden::make("type")->default(
                                "umrah",
                            ),

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

                    Forms\Components\Tabs\Tab::make("Detail Paket")
                        ->icon("heroicon-o-squares-plus")
                        ->schema([
                            Forms\Components\Repeater::make("fasilitasDetails")
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make(
                                        "fasilitas_id",
                                    )
                                        ->relationship(
                                            name: "fasilitas",
                                            titleAttribute: "nama_fasilitas",
                                            modifyQueryUsing: fn(
                                                Builder $query,
                                            ) => $query
                                                ->whereIn("kategori", [
                                                    "umroh",
                                                    "umum",
                                                ])
                                                ->where("aktif", true),
                                        )
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->label("Fasilitas"),
                                ])
                                ->columnSpanFull()
                                ->collapsible()
                                ->label("Fasilitas Paket")
                                ->addActionLabel("Tambah Fasilitas")
                                ->defaultItems(0),

                            Forms\Components\Repeater::make("hotelDetails")
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make("hotel_id")
                                        ->relationship(
                                            name: "hotel",
                                            titleAttribute: "nama_hotel",
                                            modifyQueryUsing: fn(
                                                Builder $query,
                                            ) => $query->where("aktif", true),
                                        )
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->label("Hotel"),
                                    Forms\Components\DatePicker::make(
                                        "checkin",
                                    )->label("Check-in"),
                                    Forms\Components\DatePicker::make(
                                        "checkout",
                                    )->label("Check-out"),
                                ])
                                ->columns(3)
                                ->columnSpanFull()
                                ->collapsible()
                                ->label("Hotel Paket")
                                ->addActionLabel("Tambah Hotel")
                                ->defaultItems(0),

                            Forms\Components\Repeater::make("maskapaiDetails")
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make("maskapai_id")
                                        ->relationship(
                                            name: "maskapai",
                                            titleAttribute: "nama_maskapai",
                                            modifyQueryUsing: fn(
                                                Builder $query,
                                            ) => $query->where("aktif", true),
                                        )
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->label("Maskapai"),
                                    Forms\Components\Select::make(
                                        "tipe_penerbangan",
                                    )
                                        ->required()
                                        ->options([
                                            "keberangkatan" => "Keberangkatan",
                                            "kepulangan" => "Kepulangan",
                                        ])
                                        ->default("keberangkatan")
                                        ->label("Tipe Penerbangan"),
                                    Forms\Components\TextInput::make(
                                        "nomor_penerbangan",
                                    )
                                        ->maxLength(50)
                                        ->label("No. Penerbangan"),
                                    Forms\Components\TextInput::make(
                                        "bandara_keberangkatan",
                                    )
                                        ->maxLength(100)
                                        ->label("Bandara Berangkat"),
                                    Forms\Components\TextInput::make(
                                        "bandara_tujuan",
                                    )
                                        ->maxLength(100)
                                        ->label("Bandara Tujuan"),
                                    Forms\Components\DateTimePicker::make(
                                        "waktu_berangkat",
                                    )->label("Waktu Berangkat"),
                                    Forms\Components\DateTimePicker::make(
                                        "waktu_tiba",
                                    )->label("Waktu Tiba"),
                                ])
                                ->columns(2)
                                ->columnSpanFull()
                                ->collapsible()
                                ->label("Maskapai / Penerbangan")
                                ->addActionLabel("Tambah Penerbangan")
                                ->defaultItems(0),

                            Forms\Components\Repeater::make("pembimbingDetails")
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make(
                                        "pembimbing_id",
                                    )
                                        ->relationship(
                                            name: "pembimbing",
                                            titleAttribute: "nama_pembimbing",
                                            modifyQueryUsing: fn(
                                                Builder $query,
                                            ) => $query->where("aktif", true),
                                        )
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->label("Pembimbing"),
                                ])
                                ->columnSpanFull()
                                ->collapsible()
                                ->label("Pembimbing Paket")
                                ->addActionLabel("Tambah Pembimbing")
                                ->defaultItems(0),

                            Forms\Components\Repeater::make("perjalananDetails")
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make(
                                        "perjalanan_id",
                                    )
                                        ->relationship(
                                            name: "perjalanan",
                                            titleAttribute: "lokasi_perjalanan",
                                            modifyQueryUsing: fn(
                                                Builder $query,
                                            ) => $query->where("aktif", true),
                                        )
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->label("Perjalanan"),
                                    Forms\Components\DatePicker::make(
                                        "tanggal",
                                    )->label("Tanggal"),
                                ])
                                ->columns(2)
                                ->columnSpanFull()
                                ->collapsible()
                                ->label("Rencana Perjalanan")
                                ->addActionLabel("Tambah Perjalanan")
                                ->defaultItems(0),
                        ]),

                    Forms\Components\Tabs\Tab::make("Status")
                        ->icon("heroicon-o-flag")
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
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->where("type", "umrah"))
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
            "index" => Pages\ListPaketUmrohs::route("/"),
            "create" => Pages\CreatePaketUmroh::route("/create"),
            "edit" => Pages\EditPaketUmroh::route("/{record}/edit"),
        ];
    }
}
