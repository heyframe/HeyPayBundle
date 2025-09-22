<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Action;

use HeyPay\Bundle\PayBundle\Core\Bridge\Spl\ArrayObject;
use HeyPay\Bundle\PayBundle\Core\Exception\RequestNotSupportedException;
use HeyPay\Bundle\PayBundle\Core\GatewayAwareInterface;
use HeyPay\Bundle\PayBundle\Core\GatewayAwareTrait;
use HeyPay\Bundle\PayBundle\Core\Model\PaymentInterface;
use HeyPay\Bundle\PayBundle\Core\Request\Capture;
use HeyPay\Bundle\PayBundle\Core\Request\Convert;
use HeyPay\Bundle\PayBundle\Core\Request\GetHumanStatus;

class CapturePaymentAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /**
     * @param Capture $request
     */
    public function execute(mixed $request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getModel();
        $this->gateway->execute($status = new GetHumanStatus($payment));

        if ($status->isNew()) {
            $this->gateway->execute($convert = new Convert($payment, 'array', $request->getToken()));

            $payment->setDetails($convert->getResult());
        }

        $details = ArrayObject::ensureArrayObject($payment->getDetails());

        $request->setModel($details);
        try {
            $this->gateway->execute($request);
        } finally {
            $payment->setDetails($details);
        }
    }

    public function supports(mixed $request): bool
    {
        return $request instanceof Capture
            && $request->getModel() instanceof PaymentInterface;
    }
}
