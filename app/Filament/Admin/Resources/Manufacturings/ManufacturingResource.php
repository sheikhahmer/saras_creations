<?php

namespace App\Filament\Admin\Resources\Manufacturings;

use App\Filament\Admin\Resources\Manufacturings\Pages\CreateManufacturing;
use App\Filament\Admin\Resources\Manufacturings\Pages\EditManufacturing;
use App\Filament\Admin\Resources\Manufacturings\Pages\ListManufacturings;
use App\Filament\Admin\Resources\Manufacturings\Schemas\ManufacturingForm;
use App\Filament\Admin\Resources\Manufacturings\Tables\ManufacturingsTable;
use App\Models\Manufacturing;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ManufacturingResource extends Resource
{
    protected static ?string $model = Manufacturing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Manufacturing';

    public static function form(Schema $schema): Schema
    {
        return ManufacturingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ManufacturingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListManufacturings::route('/'),
            'create' => CreateManufacturing::route('/create'),
            'edit' => EditManufacturing::route('/{record}/edit'),
        ];
    }
}
