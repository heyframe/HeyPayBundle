<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Model;

interface DetailsAggregateInterface
{
    public function getDetails(): mixed;
}
