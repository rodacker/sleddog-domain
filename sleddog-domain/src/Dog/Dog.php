<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Dog;

use Cassandra\Date;
use DateTime;
use Rodacker\Sleddog\Dog\Breed\Breed;
use Rodacker\Sleddog\Dog\Owner\Owner;

class Dog
{
    public const FEMALE = 'female';
    public const MALE = 'male';

    /**
     * @var DogId
     */
    private $id;

    /**
     * @var DogChipNumber
     */
    private $chipNumber;

    /**
     * @var Owner
     */
    private $owner;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $sex;

    /**
     * @var DateTime
     */
    private $dateOfBirth;

    /**
     * @var Breed
     */
    private $breed;

    private function __construct(
        DogId $id,
        string $name,
        string $sex,
        Breed $breed,
        Owner $owner
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->sex = $sex;
        $this->breed = $breed;
        $this->owner = $owner;
    }

    public function id(): DogId
    {
        return $this->id;
    }

    public function owner(): Owner
    {
        return $this->owner;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function sex(): string
    {
        return $this->sex;
    }

    public function dateOfBirth(): ?DateTime
    {
        return $this->dateOfBirth;
    }

    public function breed(): Breed
    {
        return $this->breed;
    }

    public static function create(
        DogId $id,
        string $name,
        string $sex,
        Breed $breed,
        Owner $owner
    ): self
    {
        return new self($id, $name, $sex, $breed, $owner);
    }

    public function changeOwner(Owner $newOwner): void
    {
        $this->owner = $newOwner;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function correctDateOfBirth(DateTime $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }
}
