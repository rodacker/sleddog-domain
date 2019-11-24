<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Training;

use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\UniqueId;

final class TrainingRunId extends UniqueId
{
    public static function fromString(string $uuid): self
    {
        $uuid = Uuid::fromString($uuid);

        return new self($uuid);
    }
}
