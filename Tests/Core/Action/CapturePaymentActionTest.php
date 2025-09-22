<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Tests\Core\Action;

use HeyPay\Bundle\PayBundle\Core\Action\CapturePaymentAction;
use HeyPay\Bundle\PayBundle\Core\GatewayAwareInterface;
use PHPUnit\Framework\TestCase;

class CapturePaymentActionTest extends TestCase
{
    protected string $requestClass = Capture::class;

    protected string $actionClass = CapturePaymentAction::class;

    public function provideSupportedRequests(): \Iterator
    {
        $capture = new $this->requestClass($this->createMock(TokenInterface::class));
        $capture->setModel($this->createMock(PaymentInterface::class));
        yield [new $this->requestClass(new Payment())];
        yield [$capture];
    }

    public function testShouldImplementGatewayAwareInterface(): void
    {
        $rc = new \ReflectionClass($this->actionClass);

        static::assertTrue($rc->implementsInterface(GatewayAwareInterface::class));
    }
}
