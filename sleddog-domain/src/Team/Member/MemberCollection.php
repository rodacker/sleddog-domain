<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Team\Member;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class MemberCollection implements Countable, IteratorAggregate
{
    /**
     * @var TeamMember[]
     */
    private $members;

    public function __construct(TeamMember ...$members)
    {
        $this->members = $members;
    }

    public function add(TeamMember $member): void
    {
        $id = $member->__toString();
        $this->members[$id] = $member;
    }

    private function hasKey(string $id)
    {
        return array_key_exists($id, $this->members);
    }

    public function remove(TeamMember $member): void
    {
        $id = $member->__toString();
        if ($this->hasKey($id)) {
            $this->removeAtKey($id);
        }
    }

    public function removeByMemberId(TeamMemberId $memberId): void
    {
        $id = $memberId->__toString();
        if ($this->hasKey($id)) {
            $this->removeAtKey($id);
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->members);
    }

    public function count(): int
    {
        return count($this->members);
    }

    private function removeAtKey(string $id): void
    {
        unset($this->members[$id]);
    }

    public function has(TeamMember $member): bool
    {
        return in_array($member, $this->members, true);
    }
}
