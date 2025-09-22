<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Registry;

use HeyPay\Bundle\PayBundle\Core\DI\ContainerConfiguration;
use HeyPay\Bundle\PayBundle\Core\Exception\InvalidArgumentException;

interface GatewayFactoryRegistryInterface
{
    /**
     * @throws InvalidArgumentException if gateway factory with such name not exist
     */
    public function getGatewayFactory(string $name): ContainerConfiguration;

    /**
     * The key must be a gateway factory name
     *
     * @return ContainerConfiguration[]
     */
    public function getGatewayFactories(): array;
}
