<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Dog;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Rodacker\Sleddog\Dog\DogId;

class DogIdTest extends TestCase
{
    public function test_id_is_valid_uuid(): void
    {
        $id = new DogId();
        $this->assertInstanceOf(UuidInterface::class, $id->id());
        $this->assertTrue(Uuid::isValid($id->__toString()));
    }

    public function test_create_from_string(): void
    {
        $uuid = Uuid::uuid4()->__toString();
        $id = DogId::fromString($uuid);

        $this->assertSame($uuid, $id->__toString());
    }

    public function test_create_from_invalud_string_throws_exception(): void
    {
        $this->expectException(InvalidUuidStringException::class);
        DogId::fromString('foo');
    }
}
