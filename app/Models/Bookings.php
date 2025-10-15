<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bookings extends Model
{
    protected $fillable = ['service_id', 'date_time'];

    public function service(): HasOne
    {
        return $this->hasOne(Services::class, 'id', 'service_id');
    }

    public function service_price(): HasOne
    {
        return $this->hasOne(ServicesPrice::class, 'id', 'service__price_id');
    }
}
