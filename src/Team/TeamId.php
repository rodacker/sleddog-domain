<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Team;

use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\UniqueId;

final class TeamId extends UniqueId
{
    public static function fromString(string $uuid): self
    {
        $uuid = Uuid::fromString($uuid);

        return new self($uuid);
    }
}
