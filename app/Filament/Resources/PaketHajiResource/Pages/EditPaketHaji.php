<?php

namespace App\Filament\Resources\PaketHajiResource\Pages;

use App\Filament\Resources\PaketHajiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaketHaji extends EditRecord
{
    protected static string $resource = PaketHajiResource::class;

    protected static ?string $title = "Edit Paket Haji";

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
