<?php

namespace App\Enums;

enum DrivetrainType: string
{
    case FWD = 'fwd';   // Front Wheel Drive //

    case RWD = 'rwd';   // Rear Wheel Drive  //

    case AWD = 'awd';   // All Wheel Drive   //

    case FOUR_WD = '4wd'; // Four Wheel Drive //
}
