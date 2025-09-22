<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Gateway\Alipay\Action;

use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\Request\Capture;
use HeyPay\Bundle\PayBundle\Gateway\Alipay\AlipayApi;

class CapturePcAction implements ActionInterface
{
    public function __construct(protected readonly AlipayApi $alipayApi)
    {
    }

    public function execute(mixed $request): void
    {
    }

    public function supports(mixed $request): bool
    {
        if (!$request instanceof Capture) {
            return false;
        }

        $model = $request->getModel();

        return $model instanceof \ArrayAccess
            && isset($model['biz_content']['product_code'])
            && $model['biz_content']['product_code'] === 'FAST_INSTANT_TRADE_PAY';
    }
}
