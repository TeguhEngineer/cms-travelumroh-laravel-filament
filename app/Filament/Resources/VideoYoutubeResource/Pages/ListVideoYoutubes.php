<?php

namespace App\Filament\Resources\VideoYoutubeResource\Pages;

use App\Filament\Resources\VideoYoutubeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVideoYoutubes extends ListRecords
{
    protected static string $resource = VideoYoutubeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
