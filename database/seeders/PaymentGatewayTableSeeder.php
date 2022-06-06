<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentGateway::create([
            'name' => 'Cash On Delivery',
            'code' => 'cod',
            'subtitle' => 'Pay with cash upon delivery.',
            'title' => 'Cash On Delivery',
            'type' => 'manual'
        ]);
        PaymentGateway::create([
            'name' => 'Paystack',
            'code' => 'paystack',
            'subtitle' => 'Pay with debit bard, bank and ussd.',
            'title' => 'Credit/Debit Card Payment',
        ]);
        PaymentGateway::create([
            'name' => 'Coupon',
            'code' => 'coupon',
            'subtitle' => 'Pay with coupon',
            'title' => 'Coupon Payment',
        ]);
        PaymentGateway::create([
            'name' => 'Bank Transfer',
            'code' => 'bank',
            'subtitle' => 'Pay via Bank Transfer',
            'title' => 'Bank Payment',
        ]);
    }
}
