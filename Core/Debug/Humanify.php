<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Debug;

use HeyPay\Bundle\PayBundle\Core\Model\ModelAggregateInterface;
use HeyPay\Bundle\PayBundle\Core\Reply\HttpRedirect;

abstract class Humanify
{
    final private function __construct()
    {
    }

    public static function request(mixed $request): string
    {
        $return = self::value($request);

        $details = [];

        if ($request instanceof ModelAggregateInterface) {
            $details[] = \sprintf('model: %s', self::value($request->getModel()));
        }
        if ($request instanceof HttpRedirect) {
            $details[] = \sprintf('url: %s', $request->getUrl());
        }

        if (!empty($details)) {
            $return .= \sprintf('{%s}', implode(', ', $details));
        }

        return $return;
    }

    public static function value(mixed $value, bool $shortClass = true): string
    {
        if (\is_object($value)) {
            if ($shortClass) {
                $ro = new \ReflectionObject($value);

                return $ro->getShortName();
            }

            return $value::class;
        }

        return \gettype($value);
    }
}
