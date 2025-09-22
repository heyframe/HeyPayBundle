<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Builder;

use HeyPay\Bundle\PayBundle\ContainerAwareCoreGatewayFactory;

class CoreGatewayFactoryBuilder
{
    public function __invoke()
    {
        return \call_user_func_array([$this, 'build'], \func_get_args());
    }

    public function build(array $defaultConfig): ContainerAwareCoreGatewayFactory
    {
        return new ContainerAwareCoreGatewayFactory($defaultConfig);
    }
}
