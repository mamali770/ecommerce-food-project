<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index() 
    {
        $orders = Order::orderByDesc('created_at')->with(['address', 'orderItems'])->paginate(5);

        return view('orders.index', compact('orders'));
    }

    public function edit(Order $order) 
    {
        $order->load(['address', 'orderItems', 'user']);

        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order) 
    {
        $request->validate([
            "address" => "required|string",
            "postal_code" => "required|digits:10",
            "status" => "required|digits:1",
            "payment_status" => "required|digits:1"
        ]);

        $order->load('address');
        
        DB::transaction(function () use ($order, $request) {
            $order->update([
                "status" => $request->status,
                "payment_status" => $request->payment_status
            ]);
            $order->transaction->update([
                "status" => $request->payment_status
            ]);
            $order->address->update([
                "address" => $request->address,
                "postal_code" => $request->postal_code
            ]);
        });

        return redirect()->route('orders.index')->with('success', 'سفارش با موفقیت ویرایش شد');
    }
}
