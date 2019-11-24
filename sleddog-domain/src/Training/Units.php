<?php

namespace Rodacker\Sleddog\Training;

final class Units
{
    public const DISTANCE_KM = 'km';
    public const DISTANCE_MILES = 'miles';
    public const DISTANCE_UNITS = [
        self::DISTANCE_KM,
        self::DISTANCE_MILES
    ];

    public const SPEED_KM_PER_HOUR = 'km/h';
    public const SPEED_MILES_PER_HOUR = 'mph';
    public const SPEED_UNITS = [
      self::SPEED_KM_PER_HOUR,
      self::SPEED_MILES_PER_HOUR
    ];
}
