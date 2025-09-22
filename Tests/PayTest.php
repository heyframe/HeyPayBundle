<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Tests;

use HeyPay\Bundle\PayBundle\Core\Model\Payment;
use HeyPay\Bundle\PayBundle\Core\Pay;
use HeyPay\Bundle\PayBundle\Core\PayBuilder;
use HeyPay\Bundle\PayBundle\Core\Request\Capture;
use HeyPay\Bundle\PayBundle\Core\Storage\FilesystemStorage;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PayTest extends KernelTestCase
{
    protected ContainerInterface $container;

    protected PayBuilder $payBuilder;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->container = static::getContainer();
        $this->payBuilder = $this->container->get('pay.builder');
    }

    public function testAlipayPc(): void
    {
        /** @var Pay $pay */
        $pay = $this->container->get('pay');
        $gateway = $pay->getGateway('ali_pc');
        static::assertNotNull($gateway);
    }

    public function testPayNotNull(): void
    {
        $pay = $this->container->get('pay');
        $token = $this->container->get('pay.security.token_storage');

        static::assertInstanceOf(Pay::class, $pay);
        static::assertInstanceOf(FilesystemStorage::class, $token);
    }

    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }
}
