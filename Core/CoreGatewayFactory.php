<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core;

use HeyPay\Bundle\PayBundle\Core\Action\CapturePaymentAction;
use HeyPay\Bundle\PayBundle\Core\Action\ConvertAction;
use HeyPay\Bundle\PayBundle\Core\Action\PrependActionInterface;
use HeyPay\Bundle\PayBundle\Core\Bridge\PlainPhp\Action\GetHttpRequestAction;
use HeyPay\Bundle\PayBundle\Core\DI\ContainerConfiguration;
use HeyPay\Bundle\PayBundle\Core\Extension\EndlessCycleDetectorExtension;
use HeyPay\Bundle\PayBundle\Core\Extension\PrependExtensionInterface;
use Psr\Container\ContainerInterface;

class CoreGatewayFactory implements ContainerConfiguration, GatewayFactoryConfigInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $defaultConfig = [];

    /**
     * @param array<string, mixed> $defaultConfig
     */
    public function __construct(array $defaultConfig = [])
    {
        $this->defaultConfig = $defaultConfig;
    }

    public function configureContainer(): array
    {
        return array_merge(
            $this->defaultConfig,
            [
                'pay.default_options' => [],
                'pay.required_options' => [],
                'pay.paths' => [],
            ]
        );
    }

    public function createGateway(ContainerInterface $container): Gateway
    {
        $gateway = new Gateway();
        foreach ($this->getActions() as $action) {
            if (\is_string($action)) {
                $action = $container->get($action);
            }
            if ($action instanceof ContainerAwareInterface) {
                $action->setContainer($container);
            }
            $gateway->addAction($action, $action instanceof PrependActionInterface);
        }

        foreach ($this->getExtensions() as $extension) {
            if (\is_string($extension)) {
                $extension = $container->get($extension);
            }
            if ($extension instanceof ContainerAwareInterface) {
                $extension->setContainer($container);
            }
            $gateway->addExtension($extension, $extension instanceof PrependExtensionInterface);
        }

        return $gateway;
    }

    public function getActions(): array
    {
        return [
            GetHttpRequestAction::class,
            CapturePaymentAction::class,
        ];
    }

    public function getExtensions(): array
    {
        return [
            EndlessCycleDetectorExtension::class,
        ];
    }
}
