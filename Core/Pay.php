<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core;

use HeyPay\Bundle\PayBundle\Core\DI\ContainerConfiguration;
use HeyPay\Bundle\PayBundle\Core\Registry\RegistryInterface;
use HeyPay\Bundle\PayBundle\Core\Security\TokenInterface;
use HeyPay\Bundle\PayBundle\Core\Storage\StorageInterface;

/**
 * @template StorageType of object
 *
 * @implements RegistryInterface<StorageType>
 */
class Pay implements RegistryInterface
{
    /**
     * @param RegistryInterface<StorageType> $registry
     */
    public function __construct(
        protected RegistryInterface $registry,
        protected StorageInterface $tokenStorage
    ) {
    }

    public function getGatewayFactory(string $name): ContainerConfiguration
    {
        return $this->registry->getGatewayFactory($name);
    }

    /**
     * @return StorageInterface<TokenInterface>
     */
    public function getTokenStorage(): StorageInterface
    {
        return $this->tokenStorage;
    }

    public function getGatewayFactories(): array
    {
        return $this->registry->getGatewayFactories();
    }

    public function getGateway(string $name): GatewayInterface
    {
        return $this->registry->getGateway($name);
    }

    public function getGateways(): array
    {
        return $this->registry->getGateways();
    }

    /**
     * @return StorageInterface<StorageType>
     */
    public function getStorage(object|string $class): StorageInterface
    {
        return $this->registry->getStorage($class);
    }

    public function getStorages(): array
    {
        return $this->registry->getStorages();
    }
}
