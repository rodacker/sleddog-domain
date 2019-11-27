<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Team;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\Team\DogExistAlreadyInTeamException;
use Rodacker\Sleddog\Team\InvalidTeamPositionException;
use Rodacker\Sleddog\Team\InvalidTeamSizeException;
use Rodacker\Sleddog\Team\Member\MemberCollection;
use Rodacker\Sleddog\Team\Team;
use Rodacker\Sleddog\Team\TeamId;
use Rodacker\Sleddog\Team\TeamIsFullException;
use Rodacker\Sleddog\Team\TrainingRun\TrainingRunCollection;
use Rodacker\Sleddog\Team\Type\HitchType;
use Rodacker\Sleddog\Test\Dog\DogTest;
use Rodacker\Sleddog\Test\Team\Member\TeamMemberTest;
use Rodacker\Sleddog\Test\Training\TrainingRunTest;
use Rodacker\Sleddog\Training\TrainingRunId;

class TeamTest extends TestCase
{
    private const NAME = 'A-Team';
    private const SIZE = 12;

    public function test_create(): void
    {
        $teamId = new TeamId();
        $hitchType = HitchType::createTandem();
        $team = $this->createTeam($teamId, $hitchType);

        $this->assertSame($teamId, $team->id());
        $this->assertSame($hitchType, $team->hitchType());
        $this->assertSame(self::SIZE, $team->size());
        $this->assertSame(self::NAME, $team->name());
    }

    public function test_size_needs_to_be_greater_than_zero(): void
    {
        $this->expectSizeNeedsToBeGreaterThanZero();
        $this->createTeam(null, null, 0);
    }

    public function test_size_needs_to_be_lower_than_max_size(): void
    {
        $this->expectSizeToBeLowerThanMaxSize();
        $this->createTeam(null, null, Team::MAX_SIZE + 1);
    }

    public function test_size_needs_to_be_even_for_tandem_hitch_type(): void
    {
        $this->expectSizeToBeEvenForTandemHitchType();
        $this->createTeam(null, null, 7);
    }

    public function test_id_is_valid_uuid(): void
    {
        $team = $this->createTeam();

        $this->assertTrue(Uuid::isValid($team->id()));
    }

    public function test_rename(): void
    {
        $team = $this->createTeam();
        $this->assertSame(self::NAME, $team->name());

        $team->rename('B-Team');
        $this->assertSame('B-Team', $team->name());
    }

    public function test_resize(): void
    {
        $team = $this->createTeam();
        $this->assertSame(self::SIZE, $team->size());

        $team->resize(14);
        $this->assertSame(14, $team->size());
    }

    public function test_size_needs_to_be_greater_than_zero_on_resize(): void
    {
        $team = $this->createTeam();
        $this->assertSame(self::SIZE, $team->size());

        $this->expectSizeNeedsToBeGreaterThanZero();
        $team->resize(0);
    }

    public function test_size_needs_to_be_lower_than_max_size_on_resize(): void
    {
        $team = $this->createTeam();
        $this->assertSame(self::SIZE, $team->size());

        $this->expectSizeToBeLowerThanMaxSize();
        $team->resize(Team::MAX_SIZE + 1);
    }

    public function test_size_needs_to_be_even_for_tandem_hitch_type_on_resize(): void
    {
        $team = $this->createTeam();
        $this->assertSame(self::SIZE, $team->size());

        $this->expectSizeToBeEvenForTandemHitchType();
        $team->resize(7);
    }

    public function test_members_is_empty_collection_on_creation(): void
    {
        $team = $this->createTeam();
        $members = $team->members();
        $this->assertInstanceOf(MemberCollection::class, $members);
        $this->assertEmpty($members);
    }

    public function test_training_runs_is_empty_collection_on_creation(): void
    {
        $team = $this->createTeam();
        $trainingRuns = $team->trainingRuns();
        $this->assertInstanceOf(TrainingRunCollection::class, $trainingRuns);
        $this->assertEmpty($trainingRuns);
    }

    public function test_can_not_add_dog_if_team_is_full(): void
    {
        $team = $this->createTeam(null, null, 2);
        $dogOne = DogTest::createDog();
        $dogTwo = DogTest::createDog();
        $dogThree = DogTest::createDog();
        $team->addDog($dogOne, 1);
        $team->addDog($dogTwo, 2);

        $this->expectException(TeamIsFullException::class);
        $team->addDog($dogThree, 3);
    }

    public function test_can_not_add_dog_at_a_position_greater_than_the_team_size(): void
    {
        $team = $this->createTeam(null, null, 2);
        $dog = DogTest::createDog();

        $this->expectException(InvalidTeamPositionException::class);
        $this->expectExceptionMessage('Position can not be greater than the team size.');
        $team->addDog($dog, 3);
    }

    public function test_can_not_add_dog_at_same_position_more_than_once(): void
    {
        $team = $this->createTeam(null, null, 2);
        $dog = DogTest::createDog();
        $anotherDog = DogTest::createDog();

        $team->addDog($dog, 1);
        $this->expectException(InvalidTeamPositionException::class);
        $this->expectExceptionMessage('A member at position [1] exists already.');
        $team->addDog($anotherDog, 1);
    }

    public function test_can_not_add_dog_with_same_dog_more_than_once(): void
    {
        $team = $this->createTeam(null, null, 2);
        $dog = DogTest::createDog();

        $team->addDog($dog, 1);
        $this->expectException(DogExistAlreadyInTeamException::class);
        $message = sprintf('A member with the dog [%s] exists already.', $dog->__toString());
        $this->expectExceptionMessage($message);
        $team->addDog($dog, 2);
    }

    public function test_remove_not_existing_member_does_not_do_anything(): void {
        $team = $this->createTeam(null, null, 2);
        $dog = DogTest::createDog();

        $team->addDog($dog, 1);
        $this->assertCount(1, $team->members());

        $notExistingMember = TeamMemberTest::createTeamMember();
        $team->remove($notExistingMember);
        $this->assertCount(1, $team->members());
    }

    public function test_remove_existing_member(): void {
        $team = self::createTeam(null, null, 2);
        $dog = DogTest::createDog();
        $team->addDog($dog, 1);
        $members = $team->members();
        foreach ($members as $member) {
            $team->remove($member);
            $this->assertCount(0, $members);
            $this->assertFalse($members->has($member));
        }
    }

    public function test_remove_not_existing_dog_does_not_do_anything(): void {
        $team = $this->createTeam(null, null, 2);
        $dog = DogTest::createDog();

        $team->addDog($dog, 1);
        $this->assertCount(1, $team->members());

        $notExistingDog = DogTest::createDog();
        $team->removeDog($notExistingDog);
        $this->assertCount(1, $team->members());
    }

    public function test_remove_existing_dog(): void {
        $team = self::createTeam(null, null, 2);
        $dog = DogTest::createDog();
        $team->addDog($dog, 1);
        $members = $team->members();
        $this->assertTrue($members->hasKey($dog->__toString()));

        $team->removeDog($dog);
        $this->assertCount(0, $members);
        $this->assertFalse($members->hasKey($dog->__toString()));
    }

    public function test_add_trainings_run(): void
    {
        $trainingsRun = TrainingRunTest::createTrainingRun();
        $team = self::createTeam();
        $this->assertCount(0, $team->trainingRuns());
        $team->addTrainingRun($trainingsRun);

        $runs = $team->trainingRuns();
        $this->assertCount(1, $runs);
        foreach ($runs as $run) {
            $this->assertSame($trainingsRun, $run);
            break;
        }
    }

    public function test_remove_trainings_run(): void
    {
        $trainigRunId = new TrainingRunId();
        $trainingRun = TrainingRunTest::createTrainingRun($trainigRunId);
        $team = self::createTeam();

        $this->assertCount(0, $team->trainingRuns());
        $team->addTrainingRun($trainingRun);

        $runs = $team->trainingRuns();
        $this->assertCount(1, $runs);
        foreach ($runs as $run) {
            $this->assertSame($trainingRun, $run);
            break;
        }
        $team->removeTrainingRun($trainingRun);
    }

    private function expectSizeNeedsToBeGreaterThanZero(): void
    {
        $this->expectException(InvalidTeamSizeException::class);
        $this->expectExceptionMessage('Team size needs to be greater than 0');
    }

    private function expectSizeToBeLowerThanMaxSize(): void
    {
        $this->expectException(InvalidTeamSizeException::class);
        $this->expectExceptionMessage('Seriously? you want to run a team of 49 dogs? You need help!');
    }

    private function expectSizeToBeEvenForTandemHitchType(): void
    {
        $this->expectException(InvalidTeamSizeException::class);
        $this->expectExceptionMessage('Tandem hitch type only allows an even team size.');
    }

    public static function createTeam(
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
            $size = self::SIZE;
        }

        if ($name === null) {
            $name = self::NAME;
        }

        return new Team($teamId, $hitchType, $size, $name);
    }
}
