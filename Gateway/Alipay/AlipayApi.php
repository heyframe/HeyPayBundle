<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Gateway\Alipay;

use Alipay\OpenAPISDK\Util\AlipayConfigUtil;
use Alipay\OpenAPISDK\Util\Model\AlipayConfig;

class AlipayApi
{
    protected AlipayConfigUtil $alipayConfigUtil;

    public function __construct(
        protected AlipayConfig $config,
    ) {
        $this->alipayConfigUtil = new AlipayConfigUtil($config);
    }

    public function getAlipayConfigUtil(): AlipayConfigUtil
    {
        return $this->alipayConfigUtil;
    }
}
