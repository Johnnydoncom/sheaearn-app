<?php
namespace App\Enums;

interface Tracking
{
    const PLACED  = 'Order Placed';
    const IN_PROGRESS = 'Order in Progress';
    const SHIPPED    = 'Shipped';
    const OUT_FOR_DELIVERY  = 'Out for Delivery';
    const DELIVERED  = 'Out for Delivery';
}
