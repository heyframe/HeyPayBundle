<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Gateway\WeChat;

use HeyPay\Bundle\PayBundle\Core\Bridge\Spl\ArrayObject;
use HeyPay\Bundle\PayBundle\Core\GatewayFactory;

class WeCahtGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config): void
    {
        parent::populateConfig($config);
    }
}
