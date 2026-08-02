<?php

namespace App\Enums;

enum CustomPriceReason:string
{
    case CUSTOM_PRICE = 'custom_price';

    case UNAVAILABLE = 'unavailable';
}
