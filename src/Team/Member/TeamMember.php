<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Team\Member;

use Rodacker\Sleddog\Dog\Dog;
use Rodacker\Sleddog\Team\Team;
use Rodacker\Sleddog\Team\Type\HitchType;

class TeamMember
{
    public const LEAD_POSITION = 'lead';
    public const SWING_POSITION = 'swing';
    public const TEAM_POSITION = 'team';
    public const WHEEL_POSITION = 'wheel';

    public const POSITIONS = [
        self::LEAD_POSITION,
        self::SWING_POSITION,
        self::TEAM_POSITION,
        self::WHEEL_POSITION,
    ];

    /**
     * @var Team
     */
    private $team;

    /**
     * @var Dog
     */
    private $dog;

    /**
     * @var int
     */
    private $position;

    public function __construct(Team $team, Dog $dog, int $position)
    {
        $this->team = $team;
        $this->dog = $dog;
        $this->position = $position;
    }

    public function __toString(): string
    {
        return $this->dog->__toString();
    }

    public function team(): Team
    {
        return $this->team;
    }

    public function dog(): Dog
    {
        return $this->dog;
    }

    public function position(): int
    {
        return $this->position;
    }

    public function positionLabel(): string
    {
        $hitchType = $this->team->hitchType();
        switch ($hitchType->__toString()) {
            case HitchType::FAN_WITH_LEADDOG:
                return $this->getFanWithLeaddogHitchPositionLabel();
                break;
            case HitchType::FAN:
                return self::TEAM_POSITION;
                break;
            case HitchType::SINGLE:
                return $this->getSingleHitchPositionLabel();
                break;
            case HitchType::TANDEM:
            default:
                return $this->getTandemHitchPositionLabel();
                break;
        }
    }

    private function getTandemHitchPositionLabel(): string
    {
        $teamSize = $this->team->size();
        $position = $this->position;

        if ($position <= 2) {
            return self::LEAD_POSITION;
        } elseif ($position === $teamSize || $position === $teamSize - 1) {
            return self::WHEEL_POSITION;
        } elseif ($position <= 4) {
            return self::SWING_POSITION;
        } else {
            return self::TEAM_POSITION;
        }
    }

    private function getSingleHitchPositionLabel(): string
    {
        $teamSize = $this->team->size();
        $position = $this->position;

        if ($position === 1) {
            return self::LEAD_POSITION;
        } elseif ($position === $teamSize) {
            return self::WHEEL_POSITION;
        } elseif ($position === 2) {
            return self::SWING_POSITION;
        } else {
            return self::TEAM_POSITION;
        }
    }

    private function getFanWithLeaddogHitchPositionLabel(): string
    {
        if ($this->position === 1) {
            return self::LEAD_POSITION;
        } else {
            return self::TEAM_POSITION;
        }
    }
}
