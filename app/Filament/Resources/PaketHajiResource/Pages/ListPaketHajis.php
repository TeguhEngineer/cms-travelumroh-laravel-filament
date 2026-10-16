<?php

namespace App\Filament\Resources\PaketHajiResource\Pages;

use App\Filament\Resources\PaketHajiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaketHajis extends ListRecords
{
    protected static string $resource = PaketHajiResource::class;

    protected static ?string $title = "Paket Haji";

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
