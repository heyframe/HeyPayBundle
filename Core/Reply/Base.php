<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Reply;

use HeyPay\Bundle\PayBundle\Core\Exception\LogicException;

abstract class Base extends LogicException implements ReplyInterface
{
}
