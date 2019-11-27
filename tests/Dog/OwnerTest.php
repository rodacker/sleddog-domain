<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Dog;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Dog\Breed\Breed;
use Rodacker\Sleddog\Dog\Owner\Owner;

class OwnerTest extends TestCase
{
    private const NAME = 'Lance Mackey';

    public function test_name_can_not_be_empty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('name can not be empty');
        Owner::create('');
    }

    public function test_create(): void
    {
        $owner = Owner::create(self::NAME);
        $this->assertSame(self::NAME, $owner->name());
    }
}
