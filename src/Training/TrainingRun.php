<?php

namespace Rodacker\Sleddog\Training;

use DateTime;
use Rodacker\Sleddog\Team\Team;
use Rodacker\Sleddog\Training\Distance\Distance;
use Rodacker\Sleddog\Training\Distance\DistanceUnit;
use Rodacker\Sleddog\Training\Duration\Duration;
use Rodacker\Sleddog\Training\Speed\Speed;
use Rodacker\Sleddog\Training\Speed\SpeedUnit;

class TrainingRun
{
    /**
     * @var TrainingRunId
     */
    private $id;

    /**
     * @var Team
     */
    private $team;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var Distance
     */
    private $distance;

    /**
     * @var Duration
     */
    private $runningTime;

    /**
     * @var Duration
     */
    private $restingTime;

    /**
     * @var Musher
     */
    private $musher;

    public function __construct(
        TrainingRunId $id,
        Team $team,
        DateTime $date,
        Distance $distance,
        Duration $runningTime,
        Duration $restingTime,
        Musher $musher
    ) {
        $this->id = $id;
        $this->team = $team;
        $this->date = $date;
        $this->distance = $distance;
        $this->runningTime = $runningTime;
        $this->restingTime = $restingTime;
        $this->musher = $musher;
    }

    public function id(): TrainingRunId
    {
        return $this->id;
    }

    public function team(): Team
    {
        return $this->team;
    }

    public function date(): DateTime
    {
        return $this->date;
    }

    public function distance(): Distance
    {
        return $this->distance;
    }

    public function runningTime(): Duration
    {
        return $this->runningTime;
    }

    public function restingTime(): Duration
    {
        return $this->restingTime;
    }

    public function musher(): Musher
    {
        return $this->musher;
    }

    public function averageMovingSpeed(): Speed
    {
        $speedUnit = $this->getSpeedUnitFromDistanceUnit();
        $hours = $this->runningTime->hours();
        $speed = $this->calculateSpeed($hours);

        return new Speed($speedUnit, $speed);
    }

    public function averageTotalSpeed(): Speed
    {
        $speedUnit = $this->getSpeedUnitFromDistanceUnit();
        $runningHours = $this->runningTime->hours();
        $restingHours = $this->restingTime->hours();
        $hours = $runningHours + $restingHours;
        $speed = $this->calculateSpeed($hours);

        return new Speed($speedUnit, $speed);
    }

    private function getSpeedUnitFromDistanceUnit(): SpeedUnit
    {
        $unit = $this->distance->unit()->unit();
        if ($unit === DistanceUnit::DISTANCE_KM) {
            $speedUnit = SpeedUnit::createKilometerUnit();
        } else {
            $speedUnit = SpeedUnit::createMilesUnit();
        }
        return $speedUnit;
    }

    private function calculateSpeed(float $hours)
    {
        $distance = $this->distance->distance();
        $speed = $distance / $hours;

        return $speed;
    }
}
