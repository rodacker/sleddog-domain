<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Team;

use Rodacker\Sleddog\Dog\Dog;
use Rodacker\Sleddog\Team\Member\MemberCollection;
use Rodacker\Sleddog\Team\Member\TeamMember;
use Rodacker\Sleddog\Team\Member\TeamMemberId;
use Rodacker\Sleddog\Team\Type\HitchType;
use Rodacker\Sleddog\Training\TrainingRun;

class Team
{
    public const MAX_SIZE = 48;

    /**
     * @var TeamId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var HitchType
     */
    private $hitchType;

    /**
     * @var int
     */
    private $size;

    /**
     * @var MemberCollection
     */
    private $members;

    /**
     * @var TrainingRun[]
     */
    private $trainingRuns;

    public function __construct(TeamId $teamId, HitchType $hitchType, int $size, string $name)
    {
        $this->id = $teamId;
        $this->hitchType = $hitchType;
        if ($this->sizeIsValid($size)) {
            $this->size = $size;
        }
        $this->name = $name;
        $this->members = new MemberCollection();
        $this->trainingRuns = [];
    }

    public function id(): TeamId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function hitchType(): HitchType
    {
        return $this->hitchType;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function resize(int $newSize): void
    {
        if ($this->sizeIsValid($newSize)) {
            $this->size = $newSize;
        }
    }

    public function members(): MemberCollection
    {
        return $this->members;
    }

    public function addDog(Dog $dog, int $position): void
    {
        if ($this->teamIsFull()) {
            throw new TeamIsFullException('You can not add more members than the team size.');
        }

        if ($position > $this->size) {
            throw new InvalidTeamPositionException('Position can not be greater than the team size.');
        }

        if ($this->hasPosition($position)) {
            throw new InvalidTeamPositionException(
                sprintf('A member at position [%s] exists already.', $position)
            );
        }

        if ($this->hasDog($dog)) {
            throw new DogExistAlreadyInTeamException(
                sprintf('A member with the dog [%s] exists already.', $dog->__toString())
            );
        }

        $member = new TeamMember($this, $dog, $position);
        $this->members->add($member);
    }

    public function remove(TeamMember $member): void
    {
        if ($this->members->has($member)) {
            $this->members->remove($member);
        }
    }

    public function removeDog(Dog $dog): void
    {
        $member = $this->getMemberFromDog($dog);
        if ($member) {
            $this->members->remove($member);
        }
    }

    public function trainingRuns(): array
    {
        return $this->trainingRuns;
    }

    /**
     * @param TrainingRun
     */
    public function addTrainingRun(TrainingRun $trainingRun): void
    {
        $trainingRun->setTeam($this);
        $this->trainingRuns->add($trainingRun);
    }

    public function removeTrainingRun(int $key): void
    {
        $this->trainingRuns->remove($key);
    }

    private function sizeIsValid($size): bool
    {
        if ($this->sizeIsZero($size)) {
            throw new InvalidTeamSizeException('Team size needs to be greater than 0.');
        } elseif ($this->sizeMaxLimitReached($size)) {
            throw new InvalidTeamSizeException("Seriously? you want to run a team of {$size} dogs? You need help!");
        } elseif ($this->isTandemHitchType() && $this->isUnevenSize($size)) {
            throw new InvalidTeamSizeException('Tandem hitch type only allows an even team size.');
        }

        return true;
    }

    private function sizeIsZero($size): bool
    {
        return $size === 0;
    }

    private function sizeMaxLimitReached($size): bool
    {
        return $size > self::MAX_SIZE;
    }

    private function isTandemHitchType(): bool
    {
        return $this->hitchType->__toString() === HitchType::TANDEM;
    }

    private function isUnevenSize($size): bool
    {
        return $size % 2 !== 0;
    }

    private function teamIsFull(): bool
    {
        return count($this->members) === $this->size;
    }

    private function hasDog(Dog $dog): bool
    {
        foreach ($this->members as $member) {
            if ($member->dog()->__toString() === $dog->__toString()) {
                return true;
            }
        }

        return false;
    }

    private function hasPosition(int $position): bool
    {
        foreach ($this->members as $member) {
            if ($member->position() === $position) {
                return true;
            }
        }

        return false;
    }

    private function getMemberFromDog(Dog $dog): ?TeamMember
    {
        foreach ($this->members as $member) {
            if ($member->dog() === $dog) {
                return $member;
            }
        }

        return null;
    }
}
