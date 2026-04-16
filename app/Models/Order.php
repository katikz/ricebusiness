<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = ['rice_id', 'quantity', 'total_price', 'status', 'customer_name', 'delivery_date', 'notes'];

    public function rice(): BelongsTo
    {
        return $this->belongsTo(Rice::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
