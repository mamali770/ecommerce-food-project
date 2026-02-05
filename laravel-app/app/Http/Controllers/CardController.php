<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function increment(Request $request)
    {
        $request->validate([
            "product_id" => "required|integer|exists:products,id",
            "qty" => "required|integer"
        ]);

        $product = Products::find($request->product_id);

        $card = $request->session()->get('card', []);

        if (isset($card[$request->product_id])) {
            if ($card[$request->product_id]["qty"] >= $product->quantity) {
                return redirect()->back()->with('error', 'موجودی محصول تمام شده است.');
            }

            $card[$request->product_id]["qty"]++;
        } else {
            $card[$request->product_id] = [
                "qty" => $request->qty,
                "name" => $product->name,
                "quantity" => $product->quantity,
                "is_sale" => isSale($product->sale_price, $product->date_on_sale_from, $product->date_on_sale_to),
                "price" => $product->price,
                "sale_price" => $product->sale_price,
                "primary_image" => $product->primary_image,
            ];
        }

        $request->session()->put('card', $card);

        return redirect()->back()->with('success', 'محصول مورد نظر با موفقیت به سبد خرید اضافه شد.');
    }

    public function card(Request $request)
    {
        $card = $request->session()->get("card");

        $addresses = auth()->user()->addresses;

        return view("card.index", compact('card', 'addresses'));
    }

    public function add(Request $request)
    {
        $request->validate([
            "product_id" => "required|integer|exists:products,id",
            "qty" => "required|integer"
        ]);

        $product = Products::find($request->product_id);

        $card = $request->session()->get('card', []);

        if ($request->qty > $product->quantity) {
            return redirect()->back()->with('error', 'درخواست شما بیش از موجودی محصول می باشد.');
        }

        if (isset($card[$request->product_id])) {
            $card[$request->product_id]["qty"] = $request->qty;
        } else {
            $card[$request->product_id] = [
                "qty" => $request->qty,
                "name" => $product->name,
                "quantity" => $product->quantity,
                "is_sale" => isSale($product->sale_price, $product->date_on_sale_from, $product->date_on_sale_to),
                "price" => $product->price,
                "sale_price" => $product->sale_price,
                "primary_image" => $product->primary_image,
            ];
        }

        $request->session()->put('card', $card);

        return redirect()->back()->with('success', 'محصول مورد نظر با موفقیت به سبد خرید اضافه شد.');
    }

    public function decrement(Request $request)
    {
        $request->validate([
            "product_id" => "required|integer|exists:products,id",
            "qty" => "required|integer"
        ]);

        $product = Products::find($request->product_id);

        $card = $request->session()->get('card', []);

        if ($request->qty == 0) {
            return redirect()->back()->with('error', 'تعداد محصول مورد نظر کمترین حد مجاز است.');
        }

        if (isset($card[$request->product_id])) {
            $card[$request->product_id]["qty"]--;
        }

        $request->session()->put('card', $card);

        return redirect()->back()->with('success', 'محصول مورد نظر با موفقیت از سبد خرید کسر شد.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            "product_id" => "required|integer|exists:products,id"
        ]);

        $card = $request->session()->get('card');

        if (isset( $card[$request->product_id] )) {
            unset($card[$request->product_id]);
        }

        $request->session()->put('card', $card);

        return redirect()->back()->with('success', 'محصول مورد نظر از سبد خرید حذف شد.');
    }

    public function clear(Request $request)
    {
        $request->session()->put('card', []);

        return redirect()->route('product.index')->with('success', 'محصولات مورد نظر با موفقیت از سبد خرید کسر شد.');
    }

    public function checkCoupon(Request $request)
    {
        $request->validate([
            "code" => "required|string"
        ]);

        $coupon = Coupon::where('code', $request->code)->where('expired_at', '>', Carbon::now())->first();

        if ($coupon != null) {
            $request->session()->put('coupon', ['code' => $coupon->code, 'percent' => $coupon->percentage]);

            return redirect()->route('card.index');
        } else {
            return redirect()->route('card.index')->withErrors(['code' => 'کد تخفیف وارد شده وجود ندارد.']);
        }
    }

    public function removeCoupon(Request $request) 
    {
        $request->validate([
            "code" => "required|string"
        ]);

        $coupon = $request->session()->get('coupon');

        if (isset($coupon)) {
            $request->session()->put('coupon', []);
            return redirect()->route('card.index')->with('warning', 'کد تخفیف حذف شد.');
        }

        return redirect()->route('card.index')->with('warning', 'کد تخفیف نا معتبر است.');
    }
}
