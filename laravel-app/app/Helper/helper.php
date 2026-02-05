<?php

use Carbon\Carbon;

function isSale($sale_price, $date_on_sale_from, $date_on_sale_to)
{
    return $sale_price != 0 && $date_on_sale_from < Carbon::now() && $date_on_sale_to > Carbon::now();
}

function salePercent($productPrice, $productSalePrice)
{
    $salePercent = (($productPrice - $productSalePrice) / $productPrice) * 100;
    return round($salePercent);
}

function productImage($imageName)
{
    return env('ADMIN_PANEL_URL') . env('PRODUCT_IMAGES_PATH') . $imageName;
}

function sendOtpSms($phone, $otpCode)
{
    ini_set("soap.wsdl_cache_enabled", "0");
    $sms = new SoapClient("http://api.payamak-panel.com/post/Send.asmx?wsdl", array("encoding" => "UTF-8"));
    $data = array(
        "username" => env('MELI_PAYAMAK_USER_NAME'),
        "password" => env('MELI_PAYAMAK_API_KEY'),
        "text" => array($otpCode),
        "to" => $phone,
        "bodyId" => "415383"
    );
    $send_Result = $sms->SendByBaseNumber($data)->SendByBaseNumberResult;
}
