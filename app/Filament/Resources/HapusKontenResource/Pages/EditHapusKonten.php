<?php

namespace App\Filament\Resources\HapusKontenResource\Pages;

use App\Filament\Resources\HapusKontenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHapusKonten extends EditRecord
{
    protected static string $resource = HapusKontenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
