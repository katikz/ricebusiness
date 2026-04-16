<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rice extends Model
{
    protected $table = 'rices';

    protected $fillable = ['name', 'price_per_kg', 'stock_quantity', 'description'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
