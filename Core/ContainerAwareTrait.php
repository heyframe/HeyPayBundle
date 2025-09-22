<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core;

use Psr\Container\ContainerInterface;

trait ContainerAwareTrait
{
    protected ContainerInterface $container;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }
}
