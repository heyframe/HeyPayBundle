<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Tests\Extension;

use HeyPay\Bundle\PayBundle\Core\Extension\Context;
use HeyPay\Bundle\PayBundle\Core\Extension\ExtensionInterface;
use HeyPay\Bundle\PayBundle\Event\ExecuteEvent;
use HeyPay\Bundle\PayBundle\Extension\EventDispatcherExtension;
use HeyPay\Bundle\PayBundle\PayEvents;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventDispatcherExtensionTest extends TestCase
{
    public function testShouldImplementExtensionInterface(): void
    {
        $rc = new \ReflectionClass(EventDispatcherExtension::class);

        static::assertTrue($rc->implementsInterface(ExtensionInterface::class));
    }

    public function testShouldTriggerEventWhenCallOnPreExecute(): void
    {
        $dispatcherMock = $this->createEventDispatcherMock();
        $dispatcherMock
            ->expects($this->once())
            ->method('dispatch')
            ->with(static::isInstanceOf(ExecuteEvent::class), PayEvents::GATEWAY_PRE_EXECUTE)
        ;

        $extension = new EventDispatcherExtension($dispatcherMock);

        $extension->onPreExecute($this->createContextMock());
    }

    public function testShouldTriggerEventWhenCallOnExecute(): void
    {
        $dispatcherMock = $this->createEventDispatcherMock();
        $dispatcherMock
            ->expects($this->once())
            ->method('dispatch')
            ->with(static::isInstanceOf(ExecuteEvent::class), PayEvents::GATEWAY_EXECUTE)
        ;

        $extension = new EventDispatcherExtension($dispatcherMock);

        $extension->onExecute($this->createContextMock());
    }

    public function testShouldTriggerEventWhenCallOnPostExecute(): void
    {
        $dispatcherMock = $this->createEventDispatcherMock();
        $dispatcherMock
            ->expects($this->once())
            ->method('dispatch')
            ->with(static::isInstanceOf(ExecuteEvent::class), PayEvents::GATEWAY_POST_EXECUTE)
        ;

        $extension = new EventDispatcherExtension($dispatcherMock);

        $extension->onPostExecute($this->createContextMock());
    }

    protected function createEventDispatcherMock(): MockObject&EventDispatcherInterface
    {
        return $this->createMock(EventDispatcherInterface::class);
    }

    protected function createContextMock(): MockObject&Context
    {
        return $this->createMock(Context::class);
    }
}
