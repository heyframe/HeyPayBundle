<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Registry;

/**
 * @template T of object
 *
 * @extends StorageRegistryInterface<T>
 */
interface RegistryInterface extends GatewayRegistryInterface, GatewayFactoryRegistryInterface, StorageRegistryInterface
{
}
