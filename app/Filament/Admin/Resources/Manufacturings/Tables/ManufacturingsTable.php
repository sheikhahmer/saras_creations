<?php

namespace App\Filament\Admin\Resources\Manufacturings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\Summarizers\Sum;

class ManufacturingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('purchase.vendor.name')
                    ->label('Vendor')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('purchase.material_name')
                    ->label('Material')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('manufacturing_cost_per_kg')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state): string => 'Rs. ' . number_format($state, 2))
                    ->summarize(
                        Sum::make()
                            ->label('Total')
                            ->formatStateUsing(fn ($state): string => 'Rs. ' . number_format($state, 2))
                    ),

                TextColumn::make('total_manufacturing_cost')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state): string => 'Rs. ' . number_format($state, 2))
                    ->summarize(
                        Sum::make()
                            ->label('Total')
                            ->formatStateUsing(fn ($state): string => 'Rs. ' . number_format($state, 2))
                    ),

                TextColumn::make('final_cost')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state): string => 'Rs. ' . number_format($state, 2))
                    ->summarize(
                        Sum::make()
                            ->label('Total')
                            ->formatStateUsing(fn ($state): string => 'Rs. ' . number_format($state, 2))
                    ),

                TextColumn::make('wastage_kg')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state): string => number_format($state, 2) . ' kg')
                    ->summarize(
                        Sum::make()
                            ->label('Total')
                            ->formatStateUsing(fn ($state): string => number_format($state, 2) . ' kg')
                    ),

                TextColumn::make('net_stock_kg')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state): string => number_format($state, 2) . ' kg')
                    ->summarize(
                        Sum::make()
                            ->label('Total')
                            ->formatStateUsing(fn ($state): string => number_format($state, 2) . ' kg')
                    ),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
