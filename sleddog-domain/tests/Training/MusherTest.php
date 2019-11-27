<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Training;

use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Training\Musher;

class MusherTest extends TestCase
{
    private const NAME = 'Big John';

    public function test_name(): void
    {
        $musher = new Musher(self::NAME);
        $this->assertSame(self::NAME, $musher->name());
    }
}
