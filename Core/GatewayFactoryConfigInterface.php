<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core;

use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\Extension\ExtensionInterface;
use Psr\Container\ContainerInterface;

interface GatewayFactoryConfigInterface
{
    public function createGateway(ContainerInterface $container): Gateway;

    /**
     * @return array<string, class-string<ActionInterface>>|list<class-string<ActionInterface>>
     */
    public function getActions(): array;

    /**
     * @return list<ExtensionInterface|class-string<ExtensionInterface>>
     */
    public function getExtensions(): array;
}
