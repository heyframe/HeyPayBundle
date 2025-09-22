<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle;

use HeyPay\Bundle\PayBundle\Core\CoreGatewayFactory;

class ContainerAwareCoreGatewayFactory extends CoreGatewayFactory
{
    public function __construct(array $defaultConfig = [])
    {
        parent::__construct($defaultConfig);
    }
}
