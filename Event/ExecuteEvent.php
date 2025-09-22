<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Event;

use HeyPay\Bundle\PayBundle\Core\Extension\Context;
use Symfony\Contracts\EventDispatcher\Event;

class ExecuteEvent extends Event
{
    public function __construct(
        protected Context $context,
    ) {
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
