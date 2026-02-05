<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Products;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            "address_id" => "required|integer|exists:user_addresses,id",
            "coupon_code" => "nullable|string",
        ]);

        $amounts = [
            "total_amount" => 0,
            "coupon_amount" => 0,
            "paying_amount" => 0
        ];

        $card = $request->session()->get('card');
        $coupon = null;

        foreach ($card as $key => $item) {
            $product = Products::where('id', $key)->where('status', 1)->where('quantity', '>=', $item['qty'])->first();

            if ($product == null) {
                unset($card[$key]);
                $request->session()->put('card', $card);

                return redirect()->route('card.index')->with('warning', 'برخی اقلام سبد خرید شما موجود نمی باشد.');
            }

            $isSale = isSale($product->sale_price, $product->date_on_sale_from, $product->date_on_sale_to);
            $price = $isSale ? $product->sale_price : $product->price;

            $amounts["total_amount"] += $price * $item['qty'];
        }

        if ($request->coupon_code != null) {
            $coupon = Coupon::where('code', $request->coupon_code)->where('expired_at', '>', Carbon::now())->first();

            if ($coupon == null) {
                $request->session()->put('coupon', []);

                return redirect()->route('card.index')->with('warning', 'کد تخفیف وارد شده نا معتبر است.');
            }
            $amounts["coupon_amount"] = ($amounts["total_amount"] * $coupon->percentage) / 100;
        }



        $amounts["paying_amount"] = $amounts["total_amount"] - $amounts["coupon_amount"];

        $api = env('PAY_API_KEY');
        $amount = $amounts["paying_amount"] * 10;
        $redirect = env('PAY_CALLBACK_URL');

        $result = $this->sendRequest($api, $amount, $redirect);
        $result = json_decode($result)->data;

        if ($result->code == 100) {
            OrderController::createOrder($card, $amounts, $result->authority, $request->address_id, $coupon, auth()->id());
            return redirect()->to('https://sandbox.zarinpal.com/pg/StartPay/' . $result->authority);
        } else {
            return redirect()->route('cart.index')->with('error', 'تراکنش با خطا مواجه شد');
        }
    }

    public function sendRequest($api, $amount, $redirect)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.zarinpal.com/pg/v4/payment/request.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "merchant_id": "' . $api . '",
            "amount": "' . $amount . '",
            "callback_url": "' . $redirect . '",
            "description": "Transaction description."
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function verifyRequest($api, $amount, $authority)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "merchant_id": "' . $api . '",
            "amount": "' . $amount . '",
            "authority": "' . $authority . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public function verify(Request $request)
    {
        $request->validate([
            "Authority" => "required",
            "Status" => "required"
        ]);

        $amount = Transaction::where('token', $request->Authority)->first()->amount;

        $result = json_decode($this->verifyRequest(env('PAY_API_KEY'), $amount * 10, $request->Authority));

        $status = 0;
        $ref_number = null;
        if (isset($result->data->code)) {
            if ($result->data->code == 100 || $result->data->code == 101) {
                $status = 1;
                $ref_number = $result->data->ref_id;
                OrderController::updateOrder($request->Authority, $ref_number);

                $request->session()->put('card', []);
                return view('payment.status', compact('status', 'ref_number'));
            } else {
                return view('payment.status', compact('status', 'ref_number'));
            }
        } else {
            return view('payment.status', compact('status', 'ref_number'));
        }
    }
}
