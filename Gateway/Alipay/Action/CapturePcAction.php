<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Gateway\Alipay\Action;

use Alipay\OpenAPISDK\ApiException;
use Alipay\OpenAPISDK\Util\GenericExecuteApi;
use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\Bridge\Spl\ArrayObject;
use HeyPay\Bundle\PayBundle\Core\Exception\RequestNotSupportedException;
use HeyPay\Bundle\PayBundle\Core\Request\Capture;
use HeyPay\Bundle\PayBundle\Gateway\Alipay\AlipayApi;

class CapturePcAction implements ActionInterface
{
    public function __construct(protected readonly AlipayApi $alipayApi)
    {
    }

    /**
     * @param Capture $request
     */
    public function execute(mixed $request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);
        $model = ArrayObject::ensureArrayObject($request->getModel());

        $execute = new GenericExecuteApi($this->alipayApi->getAlipayConfigUtil());
        try {
            $pageExecute = $execute->pageExecute('alipay.trade.page.pay', 'POST', $model['biz_content']);
        } catch (ApiException $e) {
            echo $e->getMessage();
        }
        echo $pageExecute;
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
