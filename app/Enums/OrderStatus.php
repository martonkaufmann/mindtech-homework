<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatus: string
{
    case Received = 'received';
    case Preparing = 'preparing';
    case Ready = 'ready';
    case Delivered = 'delivered';
}
