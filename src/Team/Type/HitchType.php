<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Team\Type;

class HitchType
{
    public const TANDEM = 'tandem';
    public const SINGLE = 'single';
    public const FAN = 'fan';
    public const FAN_WITH_LEADDOG = 'fan with leaddog';

    /**
     * @var string
     */
    private $type;

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public static function createTandem(): self
    {
        return new self(self::TANDEM);
    }

    public static function createSingle(): self
    {
        return new self(self::SINGLE);
    }

    public static function createFan(): self
    {
        return new self(self::FAN);
    }

    public static function createFanWithLeaddog(): self
    {
        return new self(self::FAN_WITH_LEADDOG);
    }
}
