<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Dog;

use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\UniqueId;

final class DogId extends UniqueId
{
    public static function fromString(string $uuid): self
    {
        $uuid = Uuid::fromString($uuid);

        return new self($uuid);
    }
}
