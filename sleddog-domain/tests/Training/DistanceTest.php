<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Training;

use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Training\Distance\Distance;
use Rodacker\Sleddog\Training\Distance\DistanceUnit;

class DistanceTest extends TestCase
{
    public function test_create_km_distance(): void
    {
        $distance = Distance::createKilometerDistance(1.0);

        $expectedUnit = DistanceUnit::createKilometerUnit();
        $this->assertEquals($expectedUnit, $distance->unit());
        $this->assertSame(1.0, $distance->distance());
    }

    public function test_create_miles_distance(): void
    {
        $distance = Distance::createMilesDistance(1.0);

        $expectedUnit = DistanceUnit::createMilesUnit();
        $this->assertEquals($expectedUnit, $distance->unit());
        $this->assertSame(1.0, $distance->distance());
    }
}
