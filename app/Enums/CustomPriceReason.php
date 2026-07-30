<?php

namespace App\Enums;

enum CustomPriceReason:string
{
    case CUSTOM_PRICE = 'custom_price';

    case HAS_BOOKING = 'has_booking';

    case PAUSED = 'paused';

    case UNAVAILABLE = 'unavailable';
}
