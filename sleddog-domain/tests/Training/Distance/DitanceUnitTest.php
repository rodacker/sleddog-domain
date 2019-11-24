<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Training\DIstance;

use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Training\Distance\DistanceUnit;
use Rodacker\Sleddog\Training\Distance\Unit;

class DitanceUnitTest extends TestCase
{
    public function test_create_km_distance_unit(): void
    {
        $unit = DistanceUnit::createKilometerUnit();
        $this->assertInstanceOf(Unit::class, $unit);
        $this->assertSame(DistanceUnit::DISTANCE_KM, $unit->unit());
    }

    public function test_create_miles_distance_unit(): void
    {
        $unit = DistanceUnit::createMilesUnit();
        $this->assertInstanceOf(Unit::class, $unit);
        $this->assertSame(DistanceUnit::DISTANCE_MILES, $unit->unit());
    }
}
