<?php

namespace App\Filament\Admin\Resources\Orders\Tables;

use App\Models\Order;  // Assuming you have an Order model
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Customer ID
                TextColumn::make('customer.name')
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),

                // Order Date
                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->created_at ? $record->created_at->format('d F Y') : 'N/A'), // Formats the date as '25 September 2025'


                // Order Status with Badge and Conditional Colors
                BadgeColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        $status = $record->status;
                        $color = null; // Default to null if no match

                        // Determine color based on status
                        if ($status == 'pending') {
                            $color = 'danger'; // Red for pending
                        } elseif ($status == 'confirmed') {
                            $color = 'primary'; // Blue for confirmed
                        } elseif ($status == 'shipped') {
                            $color = 'warning'; // Yellow for shipped
                        } elseif ($status == 'completed') {
                            $color = 'success'; // Green for completed
                        } elseif ($status == 'cancelled') {
                            $color = 'secondary'; // Gray for cancelled
                        }

                        return $color; // Return only the color
                    })
                    ->colors([
                        'danger' => 'pending',
                        'primary' => 'confirmed',
                        'warning' => 'shipped',
                        'success' => 'completed',
                        'secondary' => 'cancelled',
                    ]),


                // Shipping Charges (Formatted as Money using getStateUsing())
                TextColumn::make('shipping_charges')
                    ->label('Shipping Charges')
                    ->sortable()
                    ->getStateUsing(fn ($record) => 'Rs ' . number_format($record->shipping_charges, 2)),

                // Total Amount (Formatted as Money using getStateUsing())
                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->sortable()
                    ->getStateUsing(fn ($record) => 'Rs ' . number_format($record->total_amount, 2)),

            ])
            ->filters([
                // Add any filters you need for order status, customer, etc.
            ])
            ->recordActions([
                EditAction::make(),  // To edit the order
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),  // To delete multiple orders
                ]),
            ]);
    }
}
