<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Team\Member;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\Dog\Dog;
use Rodacker\Sleddog\Team\Member\TeamMember;
use Rodacker\Sleddog\Team\Member\TeamMemberId;
use Rodacker\Sleddog\Team\Team;
use Rodacker\Sleddog\Team\TeamId;
use Rodacker\Sleddog\Team\Type\HitchType;
use Rodacker\Sleddog\Test\Dog\DogTest;

class TeamMemberTest extends TestCase
{
    public const TEAM_SIZE = 12;
    public const TEAM_NAME = 'A-Team';
    const DOG_NAME = 'Svarten';

    public function test_get_id_returns_valid_uuid(): void
    {
        $teamMember = $this->createTeamMember();

        $this->assertTrue(Uuid::isValid($teamMember->id()));
    }

    public function test_to_string_returns_uuid_string(): void
    {
        $teamMemberId = new TeamMemberId();
        $teamMember = $this->createTeamMember($teamMemberId);

        $this->assertSame($teamMemberId->__toString(), $teamMember->__toString());
    }

    public function test_proxy_methods(): void
    {
        $teamMemberId = new TeamMemberId();
        $team = self::createTeam();
        $dog = self::createDog();
        $position = 12;

        $teamMember = $this->createTeamMember($teamMemberId, $team, $dog, $position);

        $this->assertSame($teamMemberId, $teamMember->id());
        $this->assertSame($team, $teamMember->team());
        $this->assertSame($dog, $teamMember->dog());
        $this->assertSame($position, $teamMember->position());
    }

    public function test_position_label_for_team_with_8_dogs_and_tandem_hitch_type(): void
    {
        $teamSize = 8;
        $team = self::createTeam(null, null, $teamSize);

        $member = $this->createTeamMember(null, $team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 2);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());

        $member = $this->createTeamMember(null, $team, null, 3);
        $this->assertSame(TeamMember::SWING_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 4);
        $this->assertSame(TeamMember::SWING_POSITION, $member->positionLabel());

        $member = $this->createTeamMember(null, $team, null, 5);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 6);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());

        $member = $this->createTeamMember(null, $team, null, 7);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 8);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_6_dogs_and_tandem_hitch_type(): void
    {
        $teamSize = 6;
        $team = self::createTeam(null, null, $teamSize);

        $member = $this->createTeamMember(null, $team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 2);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());

        $member = $this->createTeamMember(null, $team, null, 3);
        $this->assertSame(TeamMember::SWING_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 4);
        $this->assertSame(TeamMember::SWING_POSITION, $member->positionLabel());

        $member = $this->createTeamMember(null, $team, null, 5);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 6);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_4_dogs_and_tandem_hitch_type(): void
    {
        $teamSize = 4;
        $team = self::createTeam(null, null, $teamSize);

        $member = $this->createTeamMember(null, $team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 2);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());

        $member = $this->createTeamMember(null, $team, null, 3);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 4);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_2_dogs_and_tandem_hitch_type(): void
    {
        $teamSize = 2;
        $team = self::createTeam(null, null, $teamSize);

        $member = $this->createTeamMember(null, $team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 2);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_4_dogs_and_fan_hitch_type(): void
    {
        $teamSize = 4;
        $hitchType = HitchType::createFan();
        $team = self::createTeam(null, $hitchType, $teamSize);

        $member = $this->createTeamMember(null, $team, null, 1);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 2);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 3);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 4);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_4_dogs_and_fan_with_leaddog_hitch_type(): void
    {
        $teamSize = 4;
        $hitchType = HitchType::createFanWithLeaddog();
        $team = self::createTeam(null, $hitchType, $teamSize);

        $member = $this->createTeamMember(null, $team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 2);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 3);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 4);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_4_dogs_and_single_hitch_type(): void
    {
        $teamSize = 4;
        $hitchType = HitchType::createSingle();
        $team = self::createTeam(null, $hitchType, $teamSize);

        $member = $this->createTeamMember(null, $team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 2);
        $this->assertSame(TeamMember::SWING_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 3);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember(null, $team, null, 4);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
    }

    private static function createTeamMember(
        TeamMemberId $teamMemberId = null,
        Team $team = null,
        Dog $dog = null,
        int $position = null
    ): TeamMember {
        if ($teamMemberId === null) {
            $teamMemberId = new TeamMemberId();
        }

        if ($team === null) {
            $team = self::createTeam();
        }

        if ($dog === null) {
            $dog = self::createDog();
        }

        if ($position === null) {
            $position = 1;
        }

        return new TeamMember($teamMemberId, $team, $dog, $position);
    }

    private static function createTeam(
        TeamId $teamId = null,
        HitchType $hitchType = null,
        int $size = null,
        string $name = null
    ): Team {
        if ($teamId === null) {
            $teamId = new TeamId();
        }

        if ($hitchType === null) {
            $hitchType = HitchType::createTandem();
        }

        if ($size === null) {
            $size = self::TEAM_SIZE;
        }

        if ($name === null) {
            $name = self::TEAM_NAME;
        }

        return new Team($teamId, $hitchType, $size, $name);
    }

    private static function createDog(): Dog
    {
        return DogTest::createDog();
    }
}
