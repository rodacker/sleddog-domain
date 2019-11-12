<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Dog\Breed;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Dog\Breed\Breed;

class BreedTest extends TestCase
{
    private const NAME = 'Alaskan Husky';
    private const PUREBRED = true;
    private const HALF_BREED = false;

    public function test_name_can_not_be_empty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('name can not be empty');
        Breed::createPurebred('');
    }

    public function test_create_purebred(): void
    {
        $breed = Breed::createPurebred('Siberian Husky');
        $this->assertSame('Siberian Husky', $breed->name());
        $this->assertTrue($breed->isPurebred());
    }

    public function test_create_mixed_breed(): void
    {
        $breed = Breed::createMixedBreed('Alaskan Husky');
        $this->assertSame('Alaskan Husky', $breed->name());
        $this->assertFalse($breed->isPurebred());
    }
}
