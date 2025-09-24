<?php

namespace App\Filament\Admin\Resources\Purchases\Pages;

use App\Filament\Admin\Resources\Purchases\PurchaseResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchase extends CreateRecord
{
    protected static string $resource = PurchaseResource::class;
}
