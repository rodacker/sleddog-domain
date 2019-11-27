<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Team\Member;

use ArrayIterator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\Team\TrainingRun\TrainingRunCollection;
use Rodacker\Sleddog\Test\Training\TrainingRunTest;
use Rodacker\Sleddog\Training\TrainingRun;
use Rodacker\Sleddog\Training\TrainingRunId;

class TrainingRunCollectionTest extends TestCase
{
    public function test_is_empty_on_creation(): void
    {
        $collection = new TrainingRunCollection();
        $this->assertCount(0, $collection);
    }

    public function test_is_countable(): void
    {
        $collection = new TrainingRunCollection();
        $this->assertCount(0, $collection);
    }

    public function test_count_raises_after_adding(): void
    {
        $runMock = $this->createMock(TrainingRun::class);
        $collection = new TrainingRunCollection();
        $collection->add($runMock);
        $this->assertCount(1, $collection);
    }

    public function test_has_member_after_adding(): void
    {
        $runMock = $this->createMock(TrainingRun::class);
        $collection = new TrainingRunCollection();
        $this->assertFalse($collection->has($runMock));

        $collection->add($runMock);
        $this->assertTrue($collection->has($runMock));
    }

    public function test_has_run_id_as_key_after_adding_member(): void
    {
        $uuid = Uuid::uuid4()->__toString();
        $trainingRunId = TrainingRunId::fromString($uuid);
        $trainingRun = TrainingRunTest::createTrainingRun($trainingRunId);
        $collection = new TrainingRunCollection();
        $this->assertFalse($collection->hasKey($uuid));

        $collection->add($trainingRun);
        $this->assertTrue($collection->hasKey($uuid));
    }

    public function test_remove_training_run(): void
    {
        $trainingRunMock = $this->createTrainingRunMock('foo');
        $anotherTrainingRunMock = $this->createTrainingRunMock('bar');

        $collection = new TrainingRunCollection();
        $this->assertFalse($collection->has($trainingRunMock));
        $this->assertCount(0, $collection);

        $collection->add($anotherTrainingRunMock);
        $collection->add($trainingRunMock);
        $this->assertTrue($collection->has($trainingRunMock));
        $this->assertTrue($collection->has($anotherTrainingRunMock));
        $this->assertCount(2, $collection);

        $collection->remove($trainingRunMock);
        $this->assertFalse($collection->has($trainingRunMock));
        $this->assertTrue($collection->has($anotherTrainingRunMock));
        $this->assertCount(1, $collection);
    }

    public function test_get_iterator(): void
    {
        $collection = new TrainingRunCollection();
        $iterator = $collection->getIterator();
        $this->assertInstanceOf(ArrayIterator::class, $iterator);
    }

    private function createTrainingRunMock(string $id): MockObject
    {
        $trainingRunMock = $this->createMock(TrainingRun::class);
        $trainingRunMock->method('__toString')->willReturn($id);

        return $trainingRunMock;
    }


}
