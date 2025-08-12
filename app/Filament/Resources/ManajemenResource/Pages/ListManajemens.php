<?php

namespace App\Filament\Resources\ManajemenResource\Pages;

use App\Filament\Resources\ManajemenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManajemens extends ListRecords
{
    protected static string $resource = ManajemenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
