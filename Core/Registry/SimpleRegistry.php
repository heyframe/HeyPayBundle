<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Registry;

/**
 * @template T of object
 *
 * @extends AbstractRegistry<T>
 */
class SimpleRegistry extends AbstractRegistry
{
    protected function getService(object|string $id): ?object
    {
        return $id;
    }
}
