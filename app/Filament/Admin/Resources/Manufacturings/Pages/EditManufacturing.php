<?php

namespace App\Filament\Admin\Resources\Manufacturings\Pages;

use App\Filament\Admin\Resources\Manufacturings\ManufacturingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditManufacturing extends EditRecord
{
    protected static string $resource = ManufacturingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
