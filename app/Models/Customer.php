<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone_no',
        'address',
        'city',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
