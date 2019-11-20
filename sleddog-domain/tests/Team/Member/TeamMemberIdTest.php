<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Team\Member;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\Team\Member\TeamMemberId;

class TeamMemberIdTest extends TestCase
{
    public function test_create_from_string(): void
    {
        $uuid = Uuid::uuid4()->__toString();
        $id = TeamMemberId::fromString($uuid);

        $this->assertSame($uuid, $id->__toString());
    }

    public function test_create_from_invalid_string_throws_exception(): void
    {
        $this->expectException(InvalidUuidStringException::class);
        TeamMemberId::fromString('foo');
    }
}
