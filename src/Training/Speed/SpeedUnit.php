<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Training\Speed;

use Rodacker\Sleddog\Training\Unit;

class SpeedUnit implements Unit
{
    public const SPEED_KM_PER_HOUR = 'km/h';
    public const SPEED_MILES_PER_HOUR = 'mph';

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
        return new self(self::SPEED_KM_PER_HOUR);
    }

    public static function createMilesUnit(): self
    {
        return new self(self::SPEED_MILES_PER_HOUR);
    }
}
