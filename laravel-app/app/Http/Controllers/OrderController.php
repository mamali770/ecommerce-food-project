<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public static function createOrder($card, $amounts, $token, $address_id, $coupon, $user_id)
    {
        DB::beginTransaction();

        $order = Order::create([
            "user_id" => $user_id,
            "address_id" => $address_id,
            "coupon_id" => $coupon == null ? null : $coupon->id,
            "total_amount" => $amounts["total_amount"],
            "coupon_amount" => $amounts["coupon_amount"],
            "paying_amount" => $amounts["paying_amount"]
        ]);

        foreach ($card as $key => $item) {
            $product = Products::where('id', $key)->first();
            $isSale = isSale($product->sale_price, $product->date_on_sale_from, $product->date_on_sale_to);
            $price = $isSale ? $product->sale_price : $product->price;
            OrderItem::create([
                "order_id" => $order->id,
                "product_id" => $key,
                "price" => $price,
                "quantity" => $item["qty"],
                "subtotal" => $price * $item["qty"],
            ]);
        }

        Transaction::create([
            "user_id" => $user_id,
            "order_id" => $order->id,
            "amount" => $amounts["paying_amount"],
            "token" => $token
        ]);

        DB::commit();
    }

    public static function updateOrder($token, $ref_number)
    {
        DB::beginTransaction();

        $transaction = Transaction::where('token', $token)->first();
        $transaction->update([
            'status' => 1,
            'ref_number' => $ref_number
        ]);

        $order = Order::find($transaction->order_id);
        $order->update([
            'status' => 1,
            'payment_status' => 1
        ]);
        
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        foreach ($orderItems as $key => $orderItem) {
            $product = Products::find($orderItem->product_id);
            $product->update([
                'quantity' => $product->quantity - $orderItem->quantity
            ]);
        }

        DB::commit();
    }
}
