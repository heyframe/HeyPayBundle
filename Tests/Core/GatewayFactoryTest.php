<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Tests\Core;

use HeyPay\Bundle\PayBundle\Core\DI\ContainerConfiguration;
use HeyPay\Bundle\PayBundle\Core\GatewayFactory;
use PHPUnit\Framework\TestCase;

class GatewayFactoryTest extends TestCase
{
    public function testShouldImplementGatewayFactoryInterface(): void
    {
        $rc = new \ReflectionClass(GatewayFactory::class);

        static::assertTrue($rc->implementsInterface(ContainerConfiguration::class));
    }
}
