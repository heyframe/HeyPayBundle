<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Extension;

use HeyPay\Bundle\PayBundle\Core\Extension\Context;
use HeyPay\Bundle\PayBundle\Core\Extension\ExtensionInterface;
use HeyPay\Bundle\PayBundle\Event\ExecuteEvent;
use HeyPay\Bundle\PayBundle\PayEvents;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class EventDispatcherExtension implements ExtensionInterface
{
    private EventDispatcherInterface $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function onPreExecute(Context $context): void
    {
        $event = new ExecuteEvent($context);
        $this->dispatcher->dispatch($event, PayEvents::GATEWAY_PRE_EXECUTE);
    }

    public function onExecute(Context $context): void
    {
        $event = new ExecuteEvent($context);
        $this->dispatcher->dispatch($event, PayEvents::GATEWAY_EXECUTE);
    }

    public function onPostExecute(Context $context): void
    {
        $event = new ExecuteEvent($context);
        $this->dispatcher->dispatch($event, PayEvents::GATEWAY_POST_EXECUTE);
    }
}
