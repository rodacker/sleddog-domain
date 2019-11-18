<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Dog;

use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Dog\DogChipNumber;

class DogChipNumberTest extends TestCase
{
    public function test_id_is_string(): void
    {
        $dogChipNumber = new DogChipNumber('foo');
        $this->assertSame('foo', $dogChipNumber->__toString());
    }
}
