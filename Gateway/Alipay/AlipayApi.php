<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Gateway\Alipay;

use Alipay\OpenAPISDK\Util\AlipayConfigUtil;
use Alipay\OpenAPISDK\Util\GenericExecuteApi;
use Alipay\OpenAPISDK\Util\Model\AlipayConfig;

class AlipayApi
{
    protected GenericExecuteApi $executeApi;
    public function __construct(
        protected AlipayConfig $config,
    ) {
        $this->executeApi = new GenericExecuteApi(new AlipayConfigUtil($this->config));
    }

    public function getExecuteApi(): GenericExecuteApi
    {
        return $this->executeApi;
    }

    public function getConfig(): AlipayConfig
    {
        return $this->config;
    }


}
