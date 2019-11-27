<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Test\Dog\Breed;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Rodacker\Sleddog\Dog\Breed\Breed;

class BreedTest extends TestCase
{
    private const HALF_BREED = 'Alaskan Husky';
    private const PUREBRED = 'Siberian Husky';

    public function test_name_can_not_be_empty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('name can not be empty');
        Breed::createPurebred('');
    }

    public function test_create_purebred(): void
    {
        $breed = Breed::createPurebred(self::PUREBRED);
        $this->assertSame(self::PUREBRED, $breed->name());
        $this->assertTrue($breed->isPurebred());
    }

    public function test_create_mixed_breed(): void
    {
        $breed = Breed::createMixedBreed(self::HALF_BREED);
        $this->assertSame(self::HALF_BREED, $breed->name());
        $this->assertFalse($breed->isPurebred());
    }
}
