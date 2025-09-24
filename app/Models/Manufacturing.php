<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturing extends Model
{
    protected $fillable = [
        'purchase_id',
        'manufacturing_cost_per_kg',
        'total_manufacturing_cost',
        'final_cost',
        'wastage_kg',
        'net_stock_kg',
    ];

    protected static function booted()
    {
        static::saving(function ($mfg) {
            $purchase = Purchase::find($mfg->purchase_id);

            if ($purchase) {
                // total manufacturing cost
                $mfg->total_manufacturing_cost = round($purchase->quantity_kg * $mfg->manufacturing_cost_per_kg, 2);

                // final cost = purchase total + manufacturing total
                $mfg->final_cost = round($purchase->total_amount + $mfg->total_manufacturing_cost, 2);

                // net stock after wastage
                $mfg->net_stock_kg = round($purchase->quantity_kg - $mfg->wastage_kg, 3);
            }
        });
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}

