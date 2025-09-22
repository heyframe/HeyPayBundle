<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle;

use HeyPay\Bundle\PayBundle\Core\Registry\AbstractRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @template T of object
 *
 * @extends AbstractRegistry<T>
 */
class ContainerAwareRegistry extends AbstractRegistry
{
    private ContainerInterface $container;

    public function __construct(array $gateways, array $storages, array $gatewayFactories, ContainerInterface $container)
    {
        parent::__construct($gateways, $storages, $gatewayFactories);

        $this->container = $container;
    }

    protected function getService($id): ?object
    {
        return $this->container->get($id);
    }
}
