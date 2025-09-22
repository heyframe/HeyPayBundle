<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core;

trait GatewayAwareTrait
{
    protected GatewayInterface $gateway;

    public function setGateway(GatewayInterface $gateway): void
    {
        $this->gateway = $gateway;
    }
}
