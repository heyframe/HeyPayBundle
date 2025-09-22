<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle;

final class PayEvents
{
    public const GATEWAY_PRE_EXECUTE = 'pay.gateway.pre_execute';

    public const GATEWAY_EXECUTE = 'pay.gateway.execute';

    public const GATEWAY_POST_EXECUTE = 'pay.gateway.post_execute';
}
