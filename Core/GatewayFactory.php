<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core;

use HeyPay\Bundle\PayBundle\Core\Action\PrependActionInterface;
use HeyPay\Bundle\PayBundle\Core\Bridge\Spl\ArrayObject;
use HeyPay\Bundle\PayBundle\Core\DI\ContainerConfiguration;
use HeyPay\Bundle\PayBundle\Core\Extension\PrependExtensionInterface;
use Psr\Container\ContainerInterface;

class GatewayFactory implements ContainerConfiguration, GatewayFactoryConfigInterface
{
    /**
     * @param array<string,mixed> $defaultConfig
     */
    public function __construct(
        protected array $defaultConfig = [],
        protected ?ContainerConfiguration $coreGatewayFactory = null
    ) {
        $this->coreGatewayFactory = $coreGatewayFactory ?: new CoreGatewayFactory();
    }

    public function configureContainer(): array
    {
        $config = ArrayObject::ensureArrayObject([]);
        $config->defaults($this->defaultConfig);
        $config->defaults($this->coreGatewayFactory->configureContainer());
        $this->populateConfig($config);

        return (array) $config;
    }

    public function createGateway(ContainerInterface $container): Gateway
    {
        $gateway = $this->coreGatewayFactory->createGateway($container);

        foreach ($this->getActions() as $action) {
            if (\is_string($action)) {
                $action = $container->get($action);
                if ($action === null) {
                    continue;
                }
            }
            if ($action instanceof ContainerAwareInterface) {
                $action->setContainer($container);
            }
            $gateway->addAction($action, $action instanceof PrependActionInterface);
        }

        foreach ($this->getExtensions() as $extension) {
            if (\is_string($extension)) {
                $extension = $container->get($extension);
                if ($extension === null) {
                    continue;
                }
            }
            if ($extension instanceof ContainerAwareInterface) {
                $extension->setContainer($container);
            }
            $gateway->addExtension($extension, $extension instanceof PrependExtensionInterface);
        }

        return $gateway;
    }

    public function getActions(): array
    {
        return [];
    }

    public function getExtensions(): array
    {
        return [];
    }

    protected function populateConfig(ArrayObject $config): void
    {
    }
}
