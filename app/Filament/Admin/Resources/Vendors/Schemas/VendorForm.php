<?php

namespace App\Filament\Admin\Resources\Vendors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->default(null),
                TextInput::make('phone_no')
                    ->tel()
                    ->numeric()
                    ->default(null),
                TextInput::make('bank_details')
                    ->default(null),
            ]);
    }
}
