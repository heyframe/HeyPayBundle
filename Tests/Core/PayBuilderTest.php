<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Tests\Core;

use HeyPay\Bundle\PayBundle\Core\DI\ContainerConfiguration;
use HeyPay\Bundle\PayBundle\Core\GatewayFactory;
use HeyPay\Bundle\PayBundle\Core\PayBuilder;
use PHPUnit\Framework\TestCase;

class PayBuilderTest extends TestCase
{
    public function testShouldPassAddedConfigToGatewayCallbackFactory(): void
    {
        $payum = (new PayBuilder())
            ->addDefaultStorages()
            ->addGatewayFactoryConfig('a_factory', [
                'foo' => 'fooVal',
            ])
            ->addGatewayFactory('a_factory', function (array $config, ContainerConfiguration $coreGatewayFactory) use (&$expectedFactory) {
                $this->assertSame([
                    'foo' => 'fooVal',
                ], $config);

                return new GatewayFactory($config, $coreGatewayFactory);
            })
            ->getPay();
    }
}
