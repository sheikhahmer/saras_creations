<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturing extends Model
{
    protected $fillable = [
        'manufacturer',
        'quantity',
        'cost_per_kg',
        'paid_amount',
        'manufactured_at',
    ];

    protected $casts = [
        'manufactured_at' => 'date',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    // Accessors if DB doesn’t support generated columns
    public function getTotalCostAttribute()
    {
        return $this->quantity * $this->cost_per_kg;
    }

    public function getDueAmountAttribute()
    {
        return $this->total_cost - $this->paid_amount;
    }
}

