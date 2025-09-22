<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\DI;

use HeyPay\Bundle\PayBundle\Core\Gateway;
use Psr\Container\ContainerInterface;

interface ContainerConfiguration
{
    /**
     * @return array<string, mixed>
     */
    public function configureContainer(): array;

    public function createGateway(ContainerInterface $container): Gateway;
}
