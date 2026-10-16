<?php

namespace App\Filament\Resources;

use App\Models\Artikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Filament\Resources\ArtikelResource\Pages;

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;

    protected static ?string $navigationIcon = "heroicon-o-newspaper";

    protected static ?string $navigationLabel = "Artikel & Blog";

    protected static ?string $navigationGroup = "Konten";

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("judul")
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(
                    fn($state, Forms\Set $set) => $set(
                        "slug",
                        Str::slug($state),
                    ),
                )
                ->label("Judul Artikel"),

            Forms\Components\TextInput::make("slug")
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->label("Slug (URL)")
                ->helperText("Otomatis terisi dari judul"),

            Forms\Components\FileUpload::make("thumbnail")
                ->image()
                ->directory("artikel-thumbnails")
                ->label("Thumbnail"),

            Forms\Components\Textarea::make("excerpt")
                ->maxLength(500)
                ->columnSpanFull()
                ->label("Ringkasan/Excerpt")
                ->helperText("Ringkasan singkat untuk preview"),

            Forms\Components\RichEditor::make("konten")
                ->required()
                ->columnSpanFull()
                ->label("Konten Artikel")
                ->toolbarButtons([
                    "bold",
                    "italic",
                    "underline",
                    "strike",
                    "link",
                    "heading",
                    "bulletList",
                    "orderedList",
                    "blockquote",
                    "codeBlock",
                ]),

            Forms\Components\TextInput::make("kategori")
                ->maxLength(100)
                ->label("Kategori")
                ->helperText("Contoh: Tips, Panduan, Berita"),

            Forms\Components\TagsInput::make("tags")
                ->label("Tags")
                ->helperText("Pisahkan dengan Enter"),

            Forms\Components\Toggle::make("aktif")
                ->required()
                ->default(true)
                ->label("Publish"),
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

                Tables\Columns\TextColumn::make("judul")
                    ->searchable()
                    ->limit(40)
                    ->label("Judul"),

                Tables\Columns\TextColumn::make("kategori")
                    ->searchable()
                    ->badge()
                    ->label("Kategori"),

                Tables\Columns\TextColumn::make("views")
                    ->numeric()
                    ->sortable()
                    ->label("Views"),

                Tables\Columns\IconColumn::make("aktif")
                    ->boolean()
                    ->label("Status"),

                Tables\Columns\TextColumn::make("published_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->label("Tanggal Publish"),

                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make("aktif")
                    ->label("Status")
                    ->placeholder("Semua")
                    ->trueLabel("Published")
                    ->falseLabel("Draft"),

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
            ->defaultSort("published_at", "desc");
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListArtikels::route("/"),
            "create" => Pages\CreateArtikel::route("/create"),
            "edit" => Pages\EditArtikel::route("/{record}/edit"),
        ];
    }
}
