<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Rodacker\Sleddog\UniqueId;

class UniqueIdTest extends TestCase
{
    public function test_id_is_valid_uuid(): void
    {
        $id = new UniqueId();
        $this->assertInstanceOf(UuidInterface::class, $id->id());
        $this->assertTrue(Uuid::isValid($id->__toString()));
    }
}
