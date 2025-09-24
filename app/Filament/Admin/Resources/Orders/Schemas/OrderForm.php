<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductVariant;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Utilities\Set;


class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(1)->schema([

                // Customer Info
                Section::make('Customer Info')->schema([
                    Select::make('customer_id')
                        ->label('Customer')
                        ->options(fn () => Customer::pluck('name', 'id','phone_no','address','city'))
                        ->searchable()
                        ->live()
                        ->required()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $customer = Customer::find($state);
                            if ($customer) {
                                $set('customer_name', $customer->name);
                                $set('phone_no', $customer->phone_no);
                                $set('customer_address', $customer->address);
                                $set('city', $customer->city);
                            } else {
                                $set('customer_name', null);
                                $set('phone_no', null);
                                $set('customer_address', null);
                                $set('city    ', null);
                            }
                        }),

                    TextInput::make('customer_name')->disabled()->dehydrated(false),
                    TextInput::make('phone_no')->label('Contact')->disabled()->dehydrated(false),
                    TextInput::make('city')->label('City')->disabled()->dehydrated(false),
                    Textarea::make('customer_address')->disabled()->dehydrated(false),
                ]) ->columns(2)
                ->columnSpanFull(),

                // Order items (repeater)
                Section::make('Order Items')->schema([
                    Repeater::make('items')
                        ->relationship('items')
                        ->schema([
                            Select::make('category_id')
                                ->label('Category')
                                ->options(fn () => Category::pluck('name','id')->toArray())
                                ->searchable()
                                ->live(),

                            Select::make('product_id')
                                ->label('Product')
                                ->options(fn ($get) => $get('category_id')
                                    ? Product::where('category_id', $get('category_id'))->pluck('name','id')->toArray()
                                    : [])
                                ->searchable()
                                ->live(),

                            Select::make('product_variant_id')
                                ->label('Variant')
                                ->options(fn ($get) => $get('product_id')
                                    ? ProductVariant::where('product_id', $get('product_id'))
                                        ->get()
                                        ->mapWithKeys(fn ($v) => [$v->id => "{$v->size} / {$v->color} - {$v->price}"])
                                        ->toArray()
                                    : [])
                                ->searchable()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $set, $get) {
                                    $variant = ProductVariant::find($state);
                                    if ($variant) {
                                        $set('price', (float) $variant->price);
                                        $qty = (float) ($get('quantity') ?? 1);
                                        $set('subtotal', (float) $variant->price * $qty);
                                    } else {
                                        $set('price', null);
                                        $set('subtotal', null);
                                    }
                                }),

                            TextInput::make('price')
                                ->label('Price')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(),

                            TextInput::make('quantity')
                                ->label('Quantity (kg)')
                                ->numeric()
                                ->step(0.5) // ✅ allow half kg
                                ->default(1)
                                ->reactive()
                                ->live(onBlur: true)
                                ->rules(function (callable $get) {
                                    return [
                                        function (string $attribute, $value, \Closure $fail) use ($get) {
                                            $variantId = $get('product_variant_id');
                                            if ($variantId) {
                                                $variant = \App\Models\ProductVariant::find($variantId);

                                                if (!$variant) {
                                                    return;
                                                }
                                                if ($variant->quantity <= 0) {
                                                    $fail("{$variant->product->name} ({$variant->size} / {$variant->color}) is out of stock.");
                                                    return;
                                                }

                                                if ($value > $variant->quantity) {
                                                    $fail("Only {$variant->quantity} left in stock for {$variant->product->name} ({$variant->size} / {$variant->color}).");
                                                }
                                            }
                                        },
                                    ];
                                })
                                ->afterStateUpdated(function ($state, $set, $get) {
                                    $price = (float) ($get('price') ?? 0);
                                    $set('subtotal', $price * (float) $state); // ✅ use float
                                }),

                            TextInput::make('subtotal')
                                ->label('Subtotal')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(),
                        ])
                        ->columns(3)
                        ->createItemButtonLabel('Add Product')
                        ->afterStateUpdated(function ($state, $set, $get) {
                            $itemsTotal = collect($state ?? [])
                                ->sum(fn ($i) => ((float) ($i['price'] ?? 0) * (float) ($i['quantity'] ?? 0)));

                            $shipping = (float) ($get('shipping_charges') ?? 0);

                            $set('total_amount', $itemsTotal + $shipping);
                        }),
                ]),

                // Order Summary
                Section::make('Order Summary')->schema([
                    TextInput::make('shipping_charges')
                        ->label('Delivery Charges')
                        ->numeric()
                        ->default(0)
                        ->reactive()
                        ->afterStateUpdated(function ($state, $set, $get) {
                            $itemsTotal = collect($get('items') ?? [])
                                ->sum(fn ($i) => ((float) ($i['price'] ?? 0) * (float) ($i['quantity'] ?? 0)));

                            $set('total_amount', $itemsTotal + (float) $state);
                        }),

                    TextInput::make('total_amount')
                        ->label('Total')
                        ->numeric()
                        ->disabled()
                        ->dehydrated()
                        ->afterStateHydrated(function ($state, $set, $get) {
                            $itemsTotal = collect($get('items') ?? [])
                                ->sum(fn ($i) => ((float) ($i['price'] ?? 0) * (float) ($i['quantity'] ?? 0)));

                            $shipping = (float) ($get('shipping_charges') ?? 0);

                            $set('total_amount', $itemsTotal + $shipping);
                        })
                        ->extraAttributes(['style' => 'font-weight:bold; font-size:16px;']),
                ]),
            ]),
            ])->columnSpanFull(),
        ]);
    }

}
