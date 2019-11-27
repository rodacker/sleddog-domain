<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Training;

use DateTime;
use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Team\Team;
use Rodacker\Sleddog\Test\Team\TeamTest;
use Rodacker\Sleddog\Training\Distance\Distance;
use Rodacker\Sleddog\Training\Duration\Duration;
use Rodacker\Sleddog\Training\Musher;
use Rodacker\Sleddog\Training\Speed\Speed;
use Rodacker\Sleddog\Training\Speed\SpeedUnit;
use Rodacker\Sleddog\Training\TrainingRun;
use Rodacker\Sleddog\Training\TrainingRunId;

class TrainingRunTest extends TestCase
{
    public const DISTANCE = 12;
    public const RUNNING_TIME = 60;
    public const RESTING_TIME = 10;
    public const MUSHER = 'Joe Redington';

    public function test_create(): void
    {
        $trainingRunId = new TrainingRunId();
        $team = TeamTest::createTeam();
        $date = new DateTime();
        $distance = Distance::createKilometerDistance(self::DISTANCE);
        $runningTime = Duration::fromMinutes(self::RUNNING_TIME);
        $restingTime = Duration::fromMinutes(self::RESTING_TIME);
        $musher = new Musher(self::MUSHER);

        $trainingRun = $this->createTrainingRun(
            $trainingRunId,
            $team,
            $date,
            $distance,
            $runningTime,
            $restingTime,
            $musher
        );

        $this->assertSame($trainingRunId, $trainingRun->id());
        $this->assertSame($trainingRunId->id()->__toString(), $trainingRun->__toString());
        $this->assertSame($team, $trainingRun->team());
        $this->assertSame($date, $trainingRun->date());
        $this->assertSame($distance, $trainingRun->distance());
        $this->assertSame($runningTime, $trainingRun->runningTime());
        $this->assertSame($restingTime, $trainingRun->restingTime());
        $this->assertSame($musher, $trainingRun->musher());
    }

    public static function createTrainingRun(
        TrainingRunId $trainingRunId = null,
        Team $team = null,
        DateTime $date = null,
        Distance $distance = null,
        Duration $runningTime = null,
        Duration $restingTime = null,
        Musher $musher = null
    ): TrainingRun {
        if ($trainingRunId === null) {
            $trainingRunId = new TrainingRunId();
        }

        if ($team === null) {
            $team = TeamTest::createTeam();
        }

        if ($date === null) {
            $date = new DateTime();
        }

        if ($distance === null) {
            $distance = Distance::createKilometerDistance(self::DISTANCE);
        }

        if ($runningTime === null) {
            $runningTime = Duration::fromMinutes(self::RUNNING_TIME);
        }

        if ($restingTime === null) {
            $restingTime = Duration::fromMinutes(self::RESTING_TIME);
        }

        if ($musher === null) {
            $musher = new Musher(self::MUSHER);
        }

        return new TrainingRun($trainingRunId, $team, $date, $distance, $runningTime, $restingTime, $musher);
    }

    /**
     * @dataProvider provideMetrics
     */
    public function test_calculate_speed_metrics(
        int $km,
        float $runningTimeInMinutes,
        float $restingTimeInMinutes,
        float $averageSpeed,
        float $totalSpeed,
        string $speedUnitType
    ): void {
        if ($speedUnitType === SpeedUnit::SPEED_KM_PER_HOUR) {
            $speedUnit = SpeedUnit::createKilometerUnit();
            $distance = Distance::createKilometerDistance($km);
        } else {
            $speedUnit = SpeedUnit::createMilesUnit();
            $distance = Distance::createMilesDistance($km);
        }

        $expectedAverageMovingSpeed = new Speed($speedUnit, $averageSpeed);
        $expectedTotalSpeed = new Speed($speedUnit, $totalSpeed);

        $runningTime = Duration::fromMinutes($runningTimeInMinutes);
        $restingTime = Duration::fromMinutes($restingTimeInMinutes);

        $trainingRun = $this->createTrainingRun(
            null,
            null,
            null,
            $distance,
            $runningTime,
            $restingTime
        );
        $averageMovingSpeed = $trainingRun->averageMovingSpeed();
        $averageTotalSpeed = $trainingRun->averageTotalSpeed();
        $this->assertEquals($expectedAverageMovingSpeed, $averageMovingSpeed, 'average moving speed is correct');
        $this->assertEquals($expectedTotalSpeed, $averageTotalSpeed, 'average total speed is correct');
    }

    public function provideMetrics()
    {
        return [
            [12, 30, 0, 24, 24, SpeedUnit::SPEED_KM_PER_HOUR],
            [100, 60, 60, 100, 50, SpeedUnit::SPEED_KM_PER_HOUR],
            [12, 60, 10, 12, 10.285714285714285, SpeedUnit::SPEED_MILES_PER_HOUR],
            [120, 427, 178, 16.861826697892273, 11.900826446280993, SpeedUnit::SPEED_MILES_PER_HOUR],
        ];
    }
}
