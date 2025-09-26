<?php

namespace App\Filament\Admin\Resources\Products;

use App\Filament\Admin\Resources\Products\Pages\CreateProduct;
use App\Filament\Admin\Resources\Products\Pages\EditProduct;
use App\Filament\Admin\Resources\Products\Pages\ListProducts;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Tabs;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use App\Filament\Admin\Resources\Products\Pages\ProductVariants;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    protected static ?string $recordTitleAttribute = 'Product';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Product Information')
                        ->schema([
                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->createOptionForm([
                                    TextInput::make('name')->required(),
                                    TextInput::make('slug')->required(),
                                    Textarea::make('description'),
                                ]),
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            Textarea::make('description')
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Tabs\Tab::make('Variants & Inventory')
                        ->schema([
                            Repeater::make('variants')
                                ->relationship('variants')
                                ->schema([
                                    TextInput::make('size')
                                        ->placeholder('e.g., 3mm, 10cm, Large')
                                        ->columnSpan(1),
                                    TextInput::make('color')
                                        ->placeholder('e.g., Blue, Red, Natural')
                                        ->columnSpan(1),
                                    TextInput::make('quantity')
                                        ->numeric()
                                        ->inputMode('decimal')
                                        ->step(0.01)
                                        ->suffix('kg')
                                        ->required()
                                        ->default(0)
                                        ->columnSpan(1),
                                    TextInput::make('price')
                                        ->numeric()
                                        ->inputMode('decimal')
                                        ->step(0.01)
                                        ->prefix('₹')
                                        ->required()
                                        ->default(0)
                                        ->columnSpan(1),
                                ])
                                ->columns(5)
                                ->defaultItems(1)
                                ->addActionLabel('Add Another Variant')
                                ->minItems(1)
                                ->reorderable(false)
                                ->label('Product Variants'),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')
                ->label('Product Name')
                ->sortable()
                ->searchable(),
            TextColumn::make('category.name')
                ->label('Category')
                ->sortable()
                ->searchable(),
        ])
        ->defaultSort('name');
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),

        ];
    }
}
