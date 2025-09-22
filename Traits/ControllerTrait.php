<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Traits;

use HeyPay\Bundle\PayBundle\Core\Pay;

trait ControllerTrait
{
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'pay' => Pay::class,
        ]);
    }
}
