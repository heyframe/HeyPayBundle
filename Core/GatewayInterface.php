<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core;

use HeyPay\Bundle\PayBundle\Core\Exception\RequestNotSupportedException;
use HeyPay\Bundle\PayBundle\Core\Reply\ReplyInterface;

interface GatewayInterface
{
    /**
     * @param bool $catchReply If false the reply behave like an exception. If true the reply will be caught internally and returned.
     *
     * @throws ReplyInterface Gateway throws reply if some external tasks have to be done. For example show a credit card form, an iframe or perform a redirect.
     * @throws RequestNotSupportedException If there is not an action which able to process the request.
     */
    public function execute(mixed $request, bool $catchReply = false): ?ReplyInterface;
}
