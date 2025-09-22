<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Gateway\Alipay\Action;

use Alipay\OpenAPISDK\Api\AlipayTradeApi;
use Alipay\OpenAPISDK\ApiException;
use Alipay\OpenAPISDK\Model\AlipayTradeFastpayRefundQueryErrorResponseModel;
use Alipay\OpenAPISDK\Model\AlipayTradeQueryModel;
use Alipay\OpenAPISDK\Model\AlipayTradeQueryResponseModel;
use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\Exception\RequestNotSupportedException;
use HeyPay\Bundle\PayBundle\Core\Model\Payment;
use HeyPay\Bundle\PayBundle\Core\Request\GetStatusInterface;
use HeyPay\Bundle\PayBundle\Gateway\Alipay\AlipayApi;

class StatusAction implements ActionInterface
{
    public function __construct(protected readonly AlipayApi $alipayApi)
    {
    }

    /**
     * @param GetStatusInterface $request
     */
    public function execute(mixed $request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);
        /** @var Payment $model */
        $model = $request->getModel();

        $apiInstance = new AlipayTradeApi(
            alipayConfigUtil: $this->alipayApi->getAlipayConfigUtil(),
        );

        $data = new AlipayTradeQueryModel();
        $data->setOutTradeNo($model->getNumber());

        $queryOptions = [];
        $queryOptions[] = 'trade_settle_info';
        $data->setQueryOptions($queryOptions);

        $response = null;
        try {
            $response = $apiInstance->query($data);
        } catch (ApiException $e) {
            $errorResponse = new AlipayTradeFastpayRefundQueryErrorResponseModel(json_decode($e->getResponseBody(), true));
            if ($errorResponse->getCode() === AlipayTradeFastpayRefundQueryErrorResponseModel::CODE_ACQ_TRADE_NOT_EXIST) {
                $request->markNew();
                return;
            }
        }

        if ($response instanceof AlipayTradeQueryResponseModel) {
            echo 333;
        }
    }

    public function supports(mixed $request): bool
    {
        return $request instanceof GetStatusInterface;
    }
}
