<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core;

use Psr\Container\ContainerInterface;

interface ContainerAwareInterface
{
    public function setContainer(ContainerInterface $container);
}
