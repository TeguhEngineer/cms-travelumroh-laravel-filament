<?php

namespace App\Filament\Resources\TrustBarResource\Pages;

use App\Filament\Resources\TrustBarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrustBar extends EditRecord
{
    protected static string $resource = TrustBarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
