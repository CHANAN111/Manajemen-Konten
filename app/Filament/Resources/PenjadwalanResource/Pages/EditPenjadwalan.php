<?php

namespace App\Filament\Resources\PenjadwalanResource\Pages;

use App\Filament\Resources\PenjadwalanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenjadwalan extends EditRecord
{
    protected static string $resource = PenjadwalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
