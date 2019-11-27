<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Dog;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Rodacker\Sleddog\Dog\DogId;

class DogIdTest extends TestCase
{
    public function test_create_from_string(): void
    {
        $uuid = Uuid::uuid4()->__toString();
        $id = DogId::fromString($uuid);

        $this->assertSame($uuid, $id->__toString());
    }

    public function test_create_from_invalid_string_throws_exception(): void
    {
        $this->expectException(InvalidUuidStringException::class);
        DogId::fromString('foo');
    }
}
