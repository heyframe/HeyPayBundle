<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core;

interface GatewayAwareInterface
{
    public function setGateway(GatewayInterface $gateway);
}
