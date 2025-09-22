<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Registry;

use HeyPay\Bundle\PayBundle\Core\Exception\InvalidArgumentException;
use HeyPay\Bundle\PayBundle\Core\GatewayInterface;

interface GatewayRegistryInterface
{
    /**
     * @throws InvalidArgumentException if gateway with such name not exist
     */
    public function getGateway(string $name): GatewayInterface;

    /**
     * The key must be a gateway name
     *
     * @return array<string, GatewayInterface>
     */
    public function getGateways(): array;
}
