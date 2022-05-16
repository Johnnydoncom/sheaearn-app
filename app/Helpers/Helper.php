<?php

if (!function_exists('pluck')) {
    function pluck($array, $value, $key = null)
    {
        $returnArray = [];
        if (count($array)) {
            foreach ($array as $item) {
                if ($key != null) {
                    $returnArray[$item->$key] = strtolower($value) == 'obj' ? $item : $item->$value;
                } else {
                    if ($value == 'obj') {
                        $returnArray[] = $item;
                    } else {
                        $returnArray[] = $item->$value;
                    }
                }
            }
        }

        return $returnArray;
    }
}

if (!function_exists('site_logo')) {
    function site_logo()
    {
        return \Illuminate\Support\Facades\Storage::url(setting('site_logo') ?? 'uploads/247-Store-Logo-Default.png');
    }
}

if (!function_exists('site_favicon')) {
    function site_favicon()
    {
        return \Illuminate\Support\Facades\Storage::url(setting('site_favicon') ?? 'uploads/247-Store-Logo-Default.png');
    }
}

if (!function_exists('money_format')) {
    function money_format($amount){
        return setting('site_currency_code') .' '. number_format($amount, 2);
    }
}

function app_money_format($amount){
    return setting('site_currency_code') .' '. number_format($amount, 2);
}

function generateUniqueOrderNumber() {
    do {
        $code = random_int(100000, 999999);
    } while (\App\Models\Order::where('order_number', "=", $code)->exists());

    return $code;
}

function generateUniqueReferenceNumber() {
    do {
        $code = \Illuminate\Support\Str::random();
    } while (\App\Models\PaymentHistory::where('transaction_reference', "=", $code)->exists());

    return $code;
}

function generateUniqueOrderItemNumber() {
//    $latestItem = \App\Models\OrderItem::orderBy('created_at','DESC')->first();
//    if($latestItem) {
//        return str_pad($latestItem->id+1, 8, 0, STR_PAD_LEFT);
//    }else {
//
//        return str_pad(1, 8, 0, STR_PAD_LEFT);
//    }

    do {
        $code = random_int(100000, 999999);
    } while (\App\Models\OrderItem::where('order_number', "=", $code)->exists());

    return $code;
}

function generateUniqueAccountId() {
    do {
        $code = random_int(100000, 999999);
    } while (\App\Models\User::where('account_id', "=", $code)->exists());

    return $code;
}


