<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
    protected $table = "products";
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }

    public function scopeSearch($query, $search)
    {
        $query->where('name', 'LIKE', '%' . $search . '%')->orWhere('description', 'LIKE', '%' . $search . '%');
    }

    public function scopeFilter($query)
    {
        if (request()->has('category')) {
            $query->where('category_id', request()->category);
        }

        if (request()->has('sortBy')) {
            switch (request()->sortBy) {
                case 'max':
                    $query->orderBy('price', 'desc');
                    break;

                case 'min':
                    $query->orderBy('price');
                    break;

                case 'bestSeller':
                    $orders = Order::where('payment_status', 1)->with('products')->get();

                    $productIds = [];
                    foreach ($orders as $order) {
                        foreach ($order->products as $product) {
                            array_push($productIds, $product->id);
                        }
                    }

                    $arrayKeys = array_keys(array_count_values($productIds));
                    $query->whereIn('id', $arrayKeys);
                    break;

                case 'sale':
                    $query->where('sale_price', '!=', 0)->where('date_on_sale_from', '<', Carbon::now())->where('date_on_sale_to', '>', Carbon::now());
                    break;
            }
        }

        return $query;
    }
}