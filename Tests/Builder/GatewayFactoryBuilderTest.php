<?php declare(strict_types=1);

namespace Builder;

use HeyPay\Bundle\PayBundle\Builder\GatewayFactoryBuilder;
use HeyPay\Bundle\PayBundle\Core\DI\ContainerConfiguration;
use HeyPay\Bundle\PayBundle\Core\GatewayFactory;
use PHPUnit\Framework\TestCase;

class GatewayFactoryBuilderTest extends TestCase
{
    public function testShouldBuildContainerAwareCoreGatewayFactory(): void
    {
        /** @var ContainerConfiguration $coreGatewayFactory */
        $coreGatewayFactory = $this->createMock(ContainerConfiguration::class);
        $defaultConfig = [
            'foo' => 'fooVal',
        ];

        $builder = new GatewayFactoryBuilder(GatewayFactory::class);

        $gatewayFactory = $builder->build($defaultConfig, $coreGatewayFactory);

        static::assertInstanceOf(GatewayFactory::class, $gatewayFactory);
    }
}
