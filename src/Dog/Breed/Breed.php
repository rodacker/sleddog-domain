<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Dog\Breed;

use InvalidArgumentException;

class Breed
{
    private const IS_PUREBRED = true;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $isPurebred;

    private function __construct(string $name, bool $isPurebred)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('name can not be empty');
        }

        $this->name = $name;
        $this->isPurebred = $isPurebred;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isPurebred(): bool
    {
        return $this->isPurebred;
    }

    public static function createPurebred(string $name): self
    {
        return new static($name, self::IS_PUREBRED);
    }

    public static function createMixedBreed(string $name): self
    {
        return new static($name, !self::IS_PUREBRED);
    }
}
