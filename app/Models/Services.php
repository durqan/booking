<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Services extends Model
{
    protected $fillable = ['name'];

    public function prices(): HasMany
    {
        return $this->hasMany(ServicesPrice::class, 'service_id', 'id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Bookings::class, 'service_id', 'id');
    }
}
