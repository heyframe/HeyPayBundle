<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Builder;

use HeyPay\Bundle\PayBundle\Core\DI\ContainerConfiguration;

class GatewayFactoryBuilder
{
    public function __construct(private readonly string $gatewayFactoryClass)
    {
    }

    public function __invoke()
    {
        return \call_user_func_array([$this, 'build'], \func_get_args());
    }

    /**
     * @return ContainerConfiguration
     */
    public function build(array $defaultConfig, ContainerConfiguration $coreGatewayFactory): ContainerConfiguration
    {
        $gatewayFactoryClass = $this->gatewayFactoryClass;

        return new $gatewayFactoryClass($defaultConfig, $coreGatewayFactory);
    }
}
