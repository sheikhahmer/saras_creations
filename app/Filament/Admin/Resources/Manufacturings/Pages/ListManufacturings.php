<?php

namespace App\Filament\Admin\Resources\Manufacturings\Pages;

use App\Filament\Admin\Resources\Manufacturings\ManufacturingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListManufacturings extends ListRecords
{
    protected static string $resource = ManufacturingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
