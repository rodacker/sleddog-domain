<?php declare(strict_types=1);

namespace Rodacker\Sleddog;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UniqueId
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public function __construct(UuidInterface $uuid = null)
    {
        if ($uuid === null) {
            $uuid = Uuid::uuid4();
        }

        $this->uuid = $uuid;
    }

    public function id(): UuidInterface
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid->__toString();
    }
}
