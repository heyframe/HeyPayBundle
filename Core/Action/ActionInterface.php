<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Action;

use HeyPay\Bundle\PayBundle\Core\Exception\RequestNotSupportedException;

interface ActionInterface
{
    /**
     * @throws RequestNotSupportedException if the action does not support the request.
     */
    public function execute(mixed $request): void;

    public function supports(mixed $request): bool;
}
