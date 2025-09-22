<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Model;

interface DetailsAwareInterface
{
    public function setDetails(iterable $details): void;
}
