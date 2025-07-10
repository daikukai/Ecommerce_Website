<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip_code',
        'shipping_country',
        'total_amount',
        'status',
    ];

    // An order belongs to a user (can be null for guest orders)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An order has many order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}