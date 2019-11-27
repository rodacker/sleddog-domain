<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Training\Duration;

use InvalidArgumentException;

class Duration
{
    /**
     * @var int
     */
    private $seconds;

    private function __construct(int $seconds)
    {
        if ($seconds < 0) {
            throw new InvalidArgumentException('duration needs to be greater than zero');
        }

        $this->seconds = $seconds;
    }

    public static function fromSeconds(int $seconds): self
    {
        return new self($seconds);
    }

    public static function fromMinutes(float $minutes): self
    {
        $seconds = (int) ($minutes * 60);

        return new self($seconds);
    }

    public static function fromHours(float $hours): self
    {
        $minutes = $hours * 60;
        $seconds = (int) ($minutes * 60);

        return new self($seconds);
    }

    public function seconds(): int
    {
        return $this->seconds;
    }

    public function minutes(): float
    {
        return $this->seconds / 60;
    }

    public function hours(): float
    {
        return $this->seconds / 3600;
    }
}
