<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Team\Member;

use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Dog\Dog;
use Rodacker\Sleddog\Team\Member\TeamMember;
use Rodacker\Sleddog\Team\Team;
use Rodacker\Sleddog\Team\Type\HitchType;
use Rodacker\Sleddog\Test\Dog\DogTest;
use Rodacker\Sleddog\Test\Team\TeamTest;

class TeamMemberTest extends TestCase
{
    public function test_proxy_methods(): void
    {
        $team = TeamTest::createTeam();
        $dog = DogTest::createDog();
        $position = 12;

        $teamMember = $this->createTeamMember($team, $dog, $position);

        $this->assertSame($team, $teamMember->team());
        $this->assertSame($dog, $teamMember->dog());
        $this->assertSame($position, $teamMember->position());
    }

    public function test_position_label_for_team_with_8_dogs_and_tandem_hitch_type(): void
    {
        $teamSize = 8;
        $team = TeamTest::createTeam(null, null, $teamSize);

        $member = $this->createTeamMember($team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 2);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());

        $member = $this->createTeamMember($team, null, 3);
        $this->assertSame(TeamMember::SWING_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 4);
        $this->assertSame(TeamMember::SWING_POSITION, $member->positionLabel());

        $member = $this->createTeamMember($team, null, 5);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 6);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());

        $member = $this->createTeamMember($team, null, 7);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 8);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_6_dogs_and_tandem_hitch_type(): void
    {
        $teamSize = 6;
        $team = TeamTest::createTeam(null, null, $teamSize);

        $member = $this->createTeamMember($team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 2);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());

        $member = $this->createTeamMember($team, null, 3);
        $this->assertSame(TeamMember::SWING_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 4);
        $this->assertSame(TeamMember::SWING_POSITION, $member->positionLabel());

        $member = $this->createTeamMember($team, null, 5);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 6);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_4_dogs_and_tandem_hitch_type(): void
    {
        $teamSize = 4;
        $team = TeamTest::createTeam(null, null, $teamSize);

        $member = $this->createTeamMember($team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 2);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());

        $member = $this->createTeamMember($team, null, 3);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 4);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_2_dogs_and_tandem_hitch_type(): void
    {
        $teamSize = 2;
        $team = TeamTest::createTeam(null, null, $teamSize);

        $member = $this->createTeamMember($team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 2);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_4_dogs_and_fan_hitch_type(): void
    {
        $teamSize = 4;
        $hitchType = HitchType::createFan();
        $team = TeamTest::createTeam(null, $hitchType, $teamSize);

        $member = $this->createTeamMember($team, null, 1);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 2);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 3);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 4);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_4_dogs_and_fan_with_leaddog_hitch_type(): void
    {
        $teamSize = 4;
        $hitchType = HitchType::createFanWithLeaddog();
        $team = TeamTest::createTeam(null, $hitchType, $teamSize);

        $member = $this->createTeamMember($team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 2);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 3);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 4);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
    }

    public function test_position_label_for_team_with_4_dogs_and_single_hitch_type(): void
    {
        $teamSize = 4;
        $hitchType = HitchType::createSingle();
        $team = TeamTest::createTeam(null, $hitchType, $teamSize);

        $member = $this->createTeamMember($team, null, 1);
        $this->assertSame(TeamMember::LEAD_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 2);
        $this->assertSame(TeamMember::SWING_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 3);
        $this->assertSame(TeamMember::TEAM_POSITION, $member->positionLabel());
        $member = $this->createTeamMember($team, null, 4);
        $this->assertSame(TeamMember::WHEEL_POSITION, $member->positionLabel());
    }

    public static function createTeamMember(
        Team $team = null,
        Dog $dog = null,
        int $position = null
    ): TeamMember {
        if ($team === null) {
            $team = TeamTest::createTeam();
        }

        if ($dog === null) {
            $dog = DogTest::createDog();
        }

        if ($position === null) {
            $position = 1;
        }

        return new TeamMember($team, $dog, $position);
    }
}
