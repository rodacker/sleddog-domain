<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Training\Duration;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Training\Duration\Duration;

class DurationTest extends TestCase
{
    /**
     * @dataProvider provideInvalidTimes
     */
    public function test_duration_with_invalid_seconds_throws_exception(int $seconds): void
    {
        $this->expectException(InvalidArgumentException::class);
        Duration::fromSeconds($seconds);
    }

    /**
     * @dataProvider provideInvalidTimes
     */
    public function test_duration_with_invalid_minutes_throws_exception(int $seconds): void
    {
        $this->expectException(InvalidArgumentException::class);
        Duration::fromMinutes($seconds);
    }

    /**
     * @dataProvider provideInvalidTimes
     */
    public function test_duration_with_invalid_hours_throws_exception(int $seconds): void
    {
        $this->expectException(InvalidArgumentException::class);
        Duration::fromHours($seconds);
    }

    public function provideInvalidTimes()
    {
        return [
            [-1],
            [-2],
            [-999],
        ];
    }

    public function test_duration_in_seconds(): void
    {
        $duration = Duration::fromSeconds(3600);
        $this->assertSame(3600, $duration->seconds());
    }

    public function test_duration_in_minutes(): void
    {
        $duration = Duration::fromSeconds(3600);
        $this->assertSame(60.0, $duration->minutes());
    }

    public function test_duration_in_hours(): void
    {
        $duration = Duration::fromSeconds(3600);
        $this->assertSame(1.0, $duration->hours());
    }

    /**
     * @dataProvider provideMinutesAndExpectedSeconds
     */
    public function test_duration_from_minutes(float $minutes, int $expectedSeconds): void
    {
        $duration = Duration::fromMinutes($minutes);
        $this->assertSame($expectedSeconds, $duration->seconds());
    }

    public function provideMinutesAndExpectedSeconds()
    {
        return [
            [0.0, 0],
            [1, 60],
            [10, 600],
            [1.5, 90],
            [1.2, 72],
            [1.2536123123, 75],
            [1.7674, 106],
        ];
    }

    /**
     * @dataProvider provideHoursAndExpectedSeconds
     */
    public function test_duration_from_hours(float $hours, int $expectedSeconds): void
    {
        $duration = Duration::fromHours($hours);
        $this->assertSame($expectedSeconds, $duration->seconds());
    }

    public function provideHoursAndExpectedSeconds()
    {
        return [
            [0.0, 0],
            [1, 3600],
            [10, 36000],
            [1.5, 5400],
            [1.2, 4320],
            [1.2536123123, 4513],
            [1.7674, 6362],
            [22.7363, 81850],
        ];
    }
}
