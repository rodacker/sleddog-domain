<?php declare(strict_types=1);

namespace Rodacker\Sleddog\Team\Type;

use PHPUnit\Framework\TestCase;

class HitchTypeTest extends TestCase
{
    public function test_create_tandem(): void
    {
        $type = HitchType::createTandem();
        $this->assertSame(HitchType::TANDEM, $type->__toString());
    }

    public function test_create_single(): void
    {
        $type = HitchType::createSingle();
        $this->assertSame(HitchType::SINGLE, $type->__toString());
    }

    public function test_create_fan(): void
    {
        $type = HitchType::createFan();
        $this->assertSame(HitchType::FAN, $type->__toString());
    }

    public function test_create_fan_with_leaddog(): void
    {
        $type = HitchType::createFanWithLeaddog();
        $this->assertSame(HitchType::FAN_WITH_LEADDOG, $type->__toString());
    }
}
