<?php
namespace App\Enums;

interface OrderStatus
{
    const PENDING   = 'pending';
    const PROCESSING = 'processing';
    const COMPLETED = 'completed';
    const DECLINED = 'declined';
    const CANCELED = 'canceled';
    const PLACED  = 'Order Placed';
    const IN_PROGRESS = 'Order in Progress';
    const SHIPPED    = 'Shipped';
    const OUT_FOR_DELIVERY  = 'Out for Delivery';
    const DELIVERED  = 'Delivered';
}
