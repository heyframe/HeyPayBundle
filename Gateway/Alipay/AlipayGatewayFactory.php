<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Gateway\Alipay;

use Alipay\OpenAPISDK\Util\Model\AlipayConfig;
use DI\Container;
use HeyPay\Bundle\PayBundle\Core\Bridge\Spl\ArrayObject;
use HeyPay\Bundle\PayBundle\Core\GatewayFactory;
use HeyPay\Bundle\PayBundle\Gateway\Alipay\Action\CapturePcAction;
use HeyPay\Bundle\PayBundle\Gateway\Alipay\Action\ConvertPaymentAction;
use HeyPay\Bundle\PayBundle\Gateway\Alipay\Action\StatusAction;

class AlipayGatewayFactory extends GatewayFactory
{
    public function getActions(): array
    {
        return [
            StatusAction::class,
            CapturePcAction::class,
            ConvertPaymentAction::class,
        ];
    }

    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            AlipayApi::class => function (Container $container) {
                $sandbox = $container->get('sandbox');
                $alipayConfig = new AlipayConfig();
                $alipayConfig->setServerUrl($sandbox ? 'https://openapi-sandbox.dl.alipaydev.com' : 'https://openapi.alipay.com');
                $alipayConfig->setAppId($container->get('app_id'));
                $alipayConfig->setPrivateKey($container->get('private_key'));
                $alipayConfig->setAlipayPublicKey($container->get('alipay_public_key'));
                return new AlipayApi($alipayConfig);
            },
        ]);
    }
}
