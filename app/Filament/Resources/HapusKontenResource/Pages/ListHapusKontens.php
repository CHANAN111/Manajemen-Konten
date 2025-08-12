<?php

namespace App\Filament\Resources\HapusKontenResource\Pages;

use App\Filament\Resources\HapusKontenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHapusKontens extends ListRecords
{
    protected static string $resource = HapusKontenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
