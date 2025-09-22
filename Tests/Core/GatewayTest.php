<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Tests\Core;

use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\Exception\LogicException;
use HeyPay\Bundle\PayBundle\Core\Exception\RequestNotSupportedException;
use HeyPay\Bundle\PayBundle\Core\Extension\Context;
use HeyPay\Bundle\PayBundle\Core\Extension\ExtensionInterface;
use HeyPay\Bundle\PayBundle\Core\Gateway;
use HeyPay\Bundle\PayBundle\Core\GatewayInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class GatewayTest extends TestCase
{
    protected PropertyAccessor $propertyAccessor;

    protected function setUp(): void
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public function testThrowRequestNotSupportedIfNoneActionSet(): void
    {
        static::expectException(RequestNotSupportedException::class);
        $request = new \stdClass();

        $gateway = new Gateway();

        $gateway->execute($request);
    }

    public function testShouldProxyRequestToActionWhichSupportsRequest(): void
    {
        $request = new \stdClass();

        $actionMock = $this->createMock(ActionInterface::class);
        $actionMock
            ->expects($this->once())
            ->method('supports')
            ->with($request)
            ->willReturn(true)
        ;
        $actionMock
            ->expects($this->once())
            ->method('execute')
            ->with($request)
        ;

        $gateway = new Gateway();
        $gateway->addAction($actionMock);

        $gateway->execute($request);
    }

    public function testShouldSetGatewayToActionIfActionAwareOfGatewayOnExecute(): void
    {
        $gateway = new Gateway();

        $actionMock = $this->createMock(ActionInterface::class);

        $actionMock
            ->expects($this->once())
            ->method('supports')
            ->willReturn(true)
        ;

        $gateway->addAction($actionMock);

        $gateway->execute(new \stdClass());
    }

    public function testShouldCallOnPostExecuteWithExceptionWhenExceptionThrown(): void
    {
        static::expectException(LogicException::class);
        $this->expectExceptionMessage('An error occurred');
        $exception = new LogicException('An error occurred');
        $request = new \stdClass();

        $actionMock = $this->createMock(ActionInterface::class);
        $actionMock
            ->expects($this->once())
            ->method('execute')
            ->willThrowException($exception)
        ;
        $actionMock
            ->method('supports')
            ->willReturn(true)
        ;

        $extensionMock = $this->createMock(ExtensionInterface::class);

        $gateway = new Gateway();
        $gateway->addAction($actionMock);
        $gateway->addExtension($extensionMock);

        $extensionMock
            ->expects($this->once())
            ->method('onPostExecute')
            ->with(static::isInstanceOf(Context::class))
            ->willReturnCallback(function (Context $context) use ($actionMock, $request, $exception, $gateway): void {
                $this->assertSame($actionMock, $context->getAction());
                $this->assertSame($request, $context->getRequest());
                $this->assertSame($exception, $context->getException());
                $this->assertSame($gateway, $context->getGateway());
                $this->assertNull($context->getReply());
            })
        ;

        $gateway->execute($request);
    }

    public function testShouldNotThrowNewExceptionIfUnsetByExtensionOnPostExecute(): void
    {
        $exception = new LogicException('An error occurred');

        $request = new \stdClass();

        $actionMock = $this->createMock(ActionInterface::class);
        $actionMock
            ->expects($this->once())
            ->method('execute')
            ->willThrowException($exception)
        ;
        $actionMock
            ->method('supports')
            ->willReturn(true)
        ;

        $extensionMock = $this->createMock(ExtensionInterface::class);

        $gateway = new Gateway();
        $gateway->addAction($actionMock);
        $gateway->addExtension($extensionMock);

        $extensionMock
            ->expects($this->once())
            ->method('onPostExecute')
            ->with(static::isInstanceOf(Context::class))
            ->willReturnCallback(function (Context $context) use ($exception): void {
                $this->assertSame($exception, $context->getException());

                $context->setException(null);
            })
        ;

        $gateway->execute($request);
    }

    public function testShouldReThrowNewExceptionProvidedThrownByExtensionOnPostExecuteIfPreviousOurException(): void
    {
        $exception = new LogicException('An error occurred');

        $request = new \stdClass();

        $actionMock = $this->createMock(ActionInterface::class);
        $actionMock
            ->expects($this->once())
            ->method('execute')
            ->willThrowException($exception)
        ;
        $actionMock
            ->method('supports')
            ->willReturn(true)
        ;

        $extensionMock = $this->createMock(ExtensionInterface::class);

        $gateway = new Gateway();
        $gateway->addAction($actionMock);
        $gateway->addExtension($extensionMock);

        $extensionMock
            ->expects($this->once())
            ->method('onPostExecute')
            ->with(static::isInstanceOf(Context::class))
            ->willReturnCallback(function (Context $context) use ($exception): void {
                throw new \InvalidArgumentException('Another error.', 0, $exception);
            })
        ;

        try {
            $gateway->execute($request);
        } catch (\Exception $e) {
            static::assertInstanceOf(\InvalidArgumentException::class, $e);
            static::assertSame('Another error.', $e->getMessage());
            static::assertSame($exception, $e->getPrevious());

            return;
        }

        static::fail('The exception is expected.');
    }

    public function testShouldImplementGatewayInterface(): void
    {
        $rc = new \ReflectionClass(Gateway::class);

        static::assertTrue($rc->implementsInterface(GatewayInterface::class));
    }
}
