<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Dog;

class ChipNumber
{
    /**
     * @var string
     */
    private $number;

    public function __construct(string $number)
    {
        $this->number = $number;
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
