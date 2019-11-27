<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Training;

use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Training\Distance\DistanceUnit;
use Rodacker\Sleddog\Training\Distance\Unit;
use Rodacker\Sleddog\Training\SpeedUnit;

class SpeedUnitTest extends TestCase
{
    public function test_create_km_per_hour_speed_unit(): void
    {
        $unit = SpeedUnit::createKilometerUnit();
        $this->assertInstanceOf(Unit::class, $unit);
        $this->assertSame(SpeedUnit::SPEED_KM_PER_HOUR, $unit->unit());
    }

    public function test_create_miles_per_hour_unit(): void
    {
        $unit = SpeedUnit::createMilesUnit();
        $this->assertInstanceOf(Unit::class, $unit);
        $this->assertSame(SpeedUnit::SPEED_MILES_PER_HOUR, $unit->unit());
    }
}
