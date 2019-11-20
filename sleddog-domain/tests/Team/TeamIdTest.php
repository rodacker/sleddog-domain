<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Team;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\Team\TeamId;

class TeamIdTest extends TestCase
{
    public function test_create_from_string(): void
    {
        $uuid = Uuid::uuid4()->__toString();
        $id = TeamId::fromString($uuid);

        $this->assertSame($uuid, $id->__toString());
    }

    public function test_create_from_invalid_string_throws_exception(): void
    {
        $this->expectException(InvalidUuidStringException::class);
        TeamId::fromString('foo');
    }
}
