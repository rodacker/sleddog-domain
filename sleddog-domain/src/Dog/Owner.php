<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Dog;

use InvalidArgumentException;

class Owner
{
    /**
     * @var string
     */
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name): self
    {
        if (empty($name)) {
            throw new InvalidArgumentException('name can not be empty');
        }

        return new static($name);
    }

    public function name(): string
    {
        return $this->name;
    }
}
