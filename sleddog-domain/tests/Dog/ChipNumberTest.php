<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Dog;

use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Dog\ChipNumber;

class ChipNumberTest extends TestCase
{
    public function test_id_is_string(): void
    {
        $dogChipNumber = new ChipNumber('foo');
        $this->assertSame('foo', $dogChipNumber->__toString());
    }
}
