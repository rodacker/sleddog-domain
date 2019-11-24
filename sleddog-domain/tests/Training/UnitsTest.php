<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Training;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Rodacker\Sleddog\Training\Units;

class UnitsTest extends TestCase
{
    public function test_distance_units(): void
    {
        $reflection = new ReflectionClass(Units::class);
        $distanceConstant = $reflection->getConstant('DISTANCE_UNITS');
        $this->assertIsArray($distanceConstant);
        $this->assertTrue(in_array(Units::DISTANCE_KM, $distanceConstant));
        $this->assertTrue(in_array(Units::DISTANCE_MILES, $distanceConstant));

        $speedConstant = $reflection->getConstant('SPEED_UNITS');
        $this->assertIsArray($speedConstant);
        $this->assertTrue(in_array(Units::SPEED_KM_PER_HOUR, $speedConstant));
        $this->assertTrue(in_array(Units::SPEED_MILES_PER_HOUR, $speedConstant));
    }
}
