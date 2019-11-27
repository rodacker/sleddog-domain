<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Training\Speed;

use Rodacker\Sleddog\Training\Duration\Duration;

class Speed
{
    /**
     * @var SpeedUnit
     */
    private $unit;

    /**
     * @var float
     */
    private $speed;

    public function __construct(SpeedUnit $unit, float $speed)
    {
        $this->unit = $unit;
        $this->speed = $speed;
    }

    public function unit(): SpeedUnit
    {
        return $this->unit;
    }

    public function speed(): float
    {
        return $this->speed;
    }

    public function __toString()
    {
        return $this->speed . ' ' . $this->unit->unit();
    }


}
