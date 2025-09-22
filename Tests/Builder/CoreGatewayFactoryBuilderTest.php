<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Tests\Builder;

use HeyPay\Bundle\PayBundle\Builder\CoreGatewayFactoryBuilder;
use HeyPay\Bundle\PayBundle\ContainerAwareCoreGatewayFactory;
use PHPUnit\Framework\TestCase;

class CoreGatewayFactoryBuilderTest extends TestCase
{
    public function testAllowUseBuilderAsAsFunction(): void
    {
        $defaultConfig = [
            'foo' => 'fooVal',
        ];

        $builder = new CoreGatewayFactoryBuilder();

        $gatewayFactory = $builder($defaultConfig);

        static::assertInstanceOf(ContainerAwareCoreGatewayFactory::class, $gatewayFactory);
    }
}
