<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Training\Distance;

class DistanceUnit implements Unit
{
    public const DISTANCE_MILES = 'miles';
    public const DISTANCE_KM = 'km';

    /**
     * @var string
     */
    private $unit;

    private function __construct(string $unit)
    {
        $this->unit = $unit;
    }

    public function unit(): string
    {
        return $this->unit;
    }

    public static function createKilometerUnit(): self
    {
        return new self(self::DISTANCE_KM);
    }

    public static function createMilesUnit(): self
    {
        return new self(self::DISTANCE_MILES);
    }
}
