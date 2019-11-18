<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Dog;

use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\Dog\Breed\Breed;
use Rodacker\Sleddog\Dog\Owner\Owner;

class DogTest extends TestCase
{
    private const NAME = 'Svarten';
    private const SEX = 'male';
    private const BREED = 'Alaskan Husky';
    private const OWNER = 'Jeff King';

    public function test_minimal_dog_create(): void
    {
        $dogId = new DogId();
        $breed = Breed::createMixedBreed(self::BREED);
        $owner = Owner::create(self::OWNER);
        $dog = $this->createDog($dogId, $breed, $owner);

        $this->assertSame($dogId, $dog->id());
        $this->assertSame(self::NAME, $dog->name());
        $this->assertSame(self::SEX, $dog->sex());
        $this->assertSame($breed, $dog->breed());
        $this->assertSame($owner, $dog->owner());
    }

    public function test_get_id_returns_valid_uuid(): void
    {
        $dog = $this->createDog();

        $this->assertTrue(Uuid::isValid($dog->id()));
    }

    public function test_change_owner(): void
    {
        $owner = Owner::create(self::OWNER);
        $dog = $this->createDog(null, null, $owner);
        $this->assertSame($owner, $dog->owner());

        $newOwner = Owner::create('McFoo');
        $dog->changeOwner($newOwner);
        $this->assertSame($newOwner, $dog->owner());
    }

    public function test_rename(): void
    {
        $dog = $this->createDog();
        $this->assertSame(self::NAME, $dog->name());

        $dog->rename('Svartenas');
        $this->assertSame('Svartenas', $dog->name());
    }

    public function test_dateofbirth_is_null_on_creation(): void
    {
        $dog = $this->createDog();
        $this->assertNull($dog->dateOfBirth());
    }

    public function test_correct_dateofbirth(): void
    {
        $dog = $this->createDog();
        $dateOfBirth = new DateTime('2019-01-02');
        $dog->correctDateOfBirth($dateOfBirth);
        $this->assertSame($dateOfBirth, $dog->dateOfBirth());
    }

    private function createDog(DogId $dogId = null, Breed $breed = null, Owner $owner = null): Dog
    {
        if ($dogId === null) {
            $dogId = new DogId();
        }

        if ($breed === null) {
            $breed = Breed::createMixedBreed(self::BREED);
        }

        if ($owner === null) {
            $owner = Owner::create(self::OWNER);
        }

        return Dog::create($dogId, self::NAME, self::SEX, $breed, $owner);
    }
}
