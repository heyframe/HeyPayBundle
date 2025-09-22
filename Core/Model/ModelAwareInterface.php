<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Model;

interface ModelAwareInterface
{
    public function setModel(mixed $model): void;
}
