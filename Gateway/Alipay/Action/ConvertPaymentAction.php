<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Gateway\Alipay\Action;

use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\Bridge\Spl\ArrayObject;
use HeyPay\Bundle\PayBundle\Core\Exception\RequestNotSupportedException;
use HeyPay\Bundle\PayBundle\Core\Model\PaymentInterface;
use HeyPay\Bundle\PayBundle\Core\Request\Convert;
use HeyPay\Bundle\PayBundle\Gateway\Alipay\AlipayApi;

class ConvertPaymentAction implements ActionInterface
{
    public function __construct(protected readonly AlipayApi $alipayApi)
    {
    }

    /**
     * @param Convert $request
     */
    public function execute(mixed $request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();
        $details = ArrayObject::ensureArrayObject($payment->getDetails());

        $biz_content = [];
        $biz_content['out_trade_no'] = $payment->getNumber();
        $biz_content['total_amount'] = number_format($payment->getTotalAmount() / 100, 2, '.', '');

        $details['biz_content'] = array_replace_recursive($biz_content, (array) $details);
        $request->setResult((array) $details);
    }

    public function supports(mixed $request): bool
    {
        return $request instanceof Convert
            && $request->getSource() instanceof PaymentInterface
            && $request->getTo() === 'array';
    }
}
