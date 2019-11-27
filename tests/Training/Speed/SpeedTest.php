<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Training\Speed;

use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Training\Speed\Speed;
use Rodacker\Sleddog\Training\Speed\SpeedUnit;

class SpeedTest extends TestCase
{
    public const SPEED = 12.0;

    public function test_create_km_per_hour_speed(): void
    {
        $speedUnit = SpeedUnit::createKilometerUnit();
        $speed = new Speed($speedUnit, self::SPEED);

        $this->assertSame($speedUnit, $speed->unit());
        $this->assertSame(self::SPEED, $speed->speed());
        $expectedSpeedAsString = self::SPEED . ' ' . SpeedUnit::SPEED_KM_PER_HOUR;
        $this->assertSame($expectedSpeedAsString, $speed->__toString());
    }

    public function test_create_miles_per_hour(): void
    {
        $speedUnit = SpeedUnit::createMilesUnit();
        $speed = new Speed($speedUnit, self::SPEED);

        $this->assertSame($speedUnit, $speed->unit());
        $this->assertSame(self::SPEED, $speed->speed());
        $expectedSpeedAsString = self::SPEED . ' ' . SpeedUnit::SPEED_MILES_PER_HOUR;
        $this->assertSame($expectedSpeedAsString, $speed->__toString());
    }
}
