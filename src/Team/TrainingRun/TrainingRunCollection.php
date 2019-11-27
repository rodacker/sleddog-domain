<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Team\TrainingRun;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Rodacker\Sleddog\Training\TrainingRun;

class TrainingRunCollection implements Countable, IteratorAggregate
{
    /**
     * @var TrainingRun[]
     */
    private $runs;

    public function __construct(TrainingRun ...$members)
    {
        $this->runs = $members;
    }

    public function add(TrainingRun $trainingRun): void
    {
        $id = $trainingRun->__toString();
        $this->runs[$id] = $trainingRun;
    }

    public function hasKey(string $id)
    {
        return array_key_exists($id, $this->runs);
    }

    public function remove(TrainingRun $trainingRun): void
    {
        $id = $trainingRun->__toString();
        if ($this->hasKey($id)) {
            $this->removeAtKey($id);
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->runs);
    }

    public function count(): int
    {
        return count($this->runs);
    }

    private function removeAtKey(string $id): void
    {
        unset($this->runs[$id]);
    }

    public function has(TrainingRun $trainingRun): bool
    {
        return in_array($trainingRun, $this->runs, true);
    }
}
