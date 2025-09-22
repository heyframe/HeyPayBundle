<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Gateway\Alipay\Action;

use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\Exception\RequestNotSupportedException;
use HeyPay\Bundle\PayBundle\Core\Request\GetStatusInterface;

class StatusAction implements ActionInterface
{
    /**
     * @param GetStatusInterface $request
     */
    public function execute(mixed $request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);
    }

    public function supports(mixed $request): bool
    {
        return $request instanceof GetStatusInterface;
    }
}
