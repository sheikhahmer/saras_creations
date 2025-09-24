<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'vendor_id',
        'material_name',
        'quantity_kg',
        'rate_per_kg',
        'total_amount',
        'purchase_date',
    ];

    protected static function booted()
    {
        static::saving(function ($purchase) {
            $purchase->total_amount = round($purchase->quantity_kg * $purchase->rate_per_kg, 2);
        });
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function manufacturing()
    {
        return $this->hasOne(Manufacturing::class);
    }
}
