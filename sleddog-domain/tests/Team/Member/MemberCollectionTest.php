<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Team\Member;

use ArrayIterator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\Team\Member\MemberCollection;
use Rodacker\Sleddog\Team\Member\TeamMember;
use Rodacker\Sleddog\Team\Member\TeamMemberId;

class MemberCollectionTest extends TestCase
{
    public function test_is_empty_on_creation(): void
    {
        $collection = new MemberCollection();
        $this->assertCount(0, $collection);
    }

    public function test_is_countable(): void
    {
        $collection = new MemberCollection();
        $this->assertCount(0, $collection);
    }

    public function test_count_raises_after_adding(): void
    {
        $memberMock = $this->createMock(TeamMember::class);
        $collection = new MemberCollection();
        $collection->add($memberMock);
        $this->assertCount(1, $collection);
    }

    public function test_has_member_after_adding(): void
    {
        $memberMock = $this->createMock(TeamMember::class);
        $collection = new MemberCollection();
        $this->assertFalse($collection->has($memberMock));

        $collection->add($memberMock);
        $this->assertTrue($collection->has($memberMock));
    }

    public function test_remove_member(): void
    {
        $memberMock = $this->createMemberMock('foo');
        $anotherMemberMock = $this->createMemberMock('bar');

        $collection = new MemberCollection();
        $this->assertFalse($collection->has($memberMock));
        $this->assertCount(0, $collection);

        $collection->add($anotherMemberMock);
        $collection->add($memberMock);
        $this->assertTrue($collection->has($memberMock));
        $this->assertTrue($collection->has($anotherMemberMock));
        $this->assertCount(2, $collection);

        $collection->remove($memberMock);
        $this->assertFalse($collection->has($memberMock));
        $this->assertTrue($collection->has($anotherMemberMock));
        $this->assertCount(1, $collection);
    }

    public function test_remove_by_member_id(): void
    {
        $memberMock = $this->createMemberMock(Uuid::NIL);
        $anotherMemberMock = $this->createMemberMock('bar');

        $collection = new MemberCollection();
        $this->assertFalse($collection->has($memberMock));
        $this->assertCount(0, $collection);

        $collection->add($anotherMemberMock);
        $collection->add($memberMock);
        $this->assertTrue($collection->has($memberMock));
        $this->assertTrue($collection->has($anotherMemberMock));
        $this->assertCount(2, $collection);

        $teamMemberId = TeamMemberId::fromString(Uuid::NIL);
        $collection->removeByMemberId($teamMemberId);
        $this->assertFalse($collection->has($memberMock));
        $this->assertTrue($collection->has($anotherMemberMock));
        $this->assertCount(1, $collection);
    }

    public function test_get_iterator(): void
    {
        $collection = new MemberCollection();
        $iterator = $collection->getIterator();
        $this->assertInstanceOf(ArrayIterator::class, $iterator);
    }

    private function createMemberMock(string $id): MockObject
    {
        $memberMock = $this->createMock(TeamMember::class);
        $memberMock->method('__toString')->willReturn($id);

        return $memberMock;
    }


}
