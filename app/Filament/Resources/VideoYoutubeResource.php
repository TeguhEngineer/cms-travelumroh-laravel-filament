<?php

namespace App\Filament\Resources;

use App\Models\VideoYoutube;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\VideoYoutubeResource\Pages;

class VideoYoutubeResource extends Resource
{
    protected static ?string $model = VideoYoutube::class;

    protected static ?string $navigationIcon = "heroicon-o-video-camera";

    protected static ?string $navigationLabel = "Video YouTube";

    protected static ?string $navigationGroup = "Konten";

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("judul")
                ->required()
                ->maxLength(255)
                ->label("Judul Video"),

            Forms\Components\TextInput::make("url_youtube")
                ->required()
                ->url()
                ->maxLength(255)
                ->label("URL YouTube")
                ->helperText("Contoh: https://www.youtube.com/watch?v=xxxxx"),

            Forms\Components\TextInput::make("thumbnail")
                ->url()
                ->maxLength(255)
                ->label("Thumbnail URL (opsional)")
                ->helperText("Jika kosong, akan otomatis dari YouTube"),

            Forms\Components\Textarea::make("deskripsi")
                ->maxLength(65535)
                ->columnSpanFull()
                ->label("Deskripsi"),

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
                Tables\Columns\TextColumn::make("judul")
                    ->searchable()
                    ->label("Judul"),

                Tables\Columns\TextColumn::make("url_youtube")
                    ->searchable()
                    ->limit(50)
                    ->label("URL YouTube"),

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
        return [];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListVideoYoutubes::route("/"),
            "create" => Pages\CreateVideoYoutube::route("/create"),
            "edit" => Pages\EditVideoYoutube::route("/{record}/edit"),
        ];
    }
}
