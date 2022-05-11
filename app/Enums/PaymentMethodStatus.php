<?php
namespace App\Enums;

interface PaymentMethodStatus
{
    const STRIPE  = 'stripe';
    const PAYPAL = 'paypal';
    const CASH = 'cash';
}
