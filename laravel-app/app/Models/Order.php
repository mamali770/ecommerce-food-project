<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'order_items', 'order_id', 'product_id')->withPivot(['quantity', 'price', 'subtotal']);
    }

    public function address() {
        return $this->belongsTo(UserAddress::class);
    }
}
