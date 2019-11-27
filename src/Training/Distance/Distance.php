<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Training\Distance;

class Distance
{
    /**
     * @var DistanceUnit
     */
    private $unit;

    /**
     * float
     */
    private $distance;

    private function __construct(DistanceUnit $unit, $distance)
    {
        $this->unit = $unit;
        $this->distance = $distance;
    }

    public static function createKilometerDistance(float $distance): self
    {
        $unit = DistanceUnit::createKilometerUnit();

        return new self($unit, $distance);
    }

    public static function createMilesDistance(float $distance): self
    {
        $unit = DistanceUnit::createMilesUnit();

        return new self($unit, $distance);
    }

    public function unit(): DistanceUnit
    {
        return $this->unit;
    }

    public function distance(): float
    {
        return $this->distance;
    }
}
