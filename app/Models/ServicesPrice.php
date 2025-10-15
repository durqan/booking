<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServicesPrice extends Model
{
    protected $fillable = ['service_id', 'name', 'price'];

    public function bookings(): HasMany
    {
        return $this->hasMany(Bookings::class, 'service_price_id', 'id');
    }
}
