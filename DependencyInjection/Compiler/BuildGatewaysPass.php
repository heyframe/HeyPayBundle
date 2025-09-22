<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\DependencyInjection\Compiler;

use HeyPay\Bundle\PayBundle\Core\Exception\LogicException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BuildGatewaysPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $registry = $container->getDefinition('pay.static_registry');

        $servicesIds = [];
        foreach ($container->findTaggedServiceIds('pay.gateway') as $serviceId => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                if (isset($attributes['gateway']) === false) {
                    throw new LogicException('The pay.gateway tag require gateway attribute.');
                }

                $servicesIds[$attributes['gateway']] = $serviceId;
            }
        }

        $registry->replaceArgument(0, $servicesIds);
    }
}
