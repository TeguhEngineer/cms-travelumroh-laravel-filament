<?php

namespace App\Filament\Resources\TrustBarResource\Pages;

use App\Filament\Resources\TrustBarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrustBars extends ListRecords
{
    protected static string $resource = TrustBarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
