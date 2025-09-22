<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Model;

interface ModelAggregateInterface
{
    public function getModel(): mixed;
}
