<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Exception;

use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\Debug\Humanify;
use HeyPay\Bundle\PayBundle\Core\Request\Generic;
use HeyPay\Bundle\PayBundle\Core\Storage\IdentityInterface;

class RequestNotSupportedException extends InvalidArgumentException
{
    protected mixed $request;

    protected ?ActionInterface $action;

    /**
     * @throws RequestNotSupportedException
     */
    public static function assertSupports(ActionInterface $action, mixed $request): void
    {
        if (!$action->supports($request)) {
            throw static::createActionNotSupported($action, $request);
        }
    }

    public static function createActionNotSupported(ActionInterface $action, mixed $request): RequestNotSupportedException
    {
        $exception = new self(\sprintf(
            'Action %s is not supported the request %s. %s',
            Humanify::value($action),
            Humanify::request($request),
            implode(' ', static::suggestions($request))
        ));

        $exception->request = $request;
        $exception->action = $action;

        return $exception;
    }

    public static function create(mixed $request): static
    {
        $exception = new self(\sprintf(
            'Request %s is not supported. %s',
            Humanify::request($request),
            implode(' ', static::suggestions($request))
        ));

        $exception->request = $request;

        return $exception;
    }

    /**
     * @return string[]
     */
    protected static function suggestions(mixed $request): array
    {
        $suggestions = [];

        if ($request instanceof Generic && $request->getModel() instanceof IdentityInterface) {
            $suggestions[] = \sprintf(
                'Make sure the storage extension for "%s" is registered to the gateway.',
                $request->getModel()->getClass()
            );

            $suggestions[] = \sprintf(
                'Make sure the storage find method returns an instance by id "%s".',
                $request->getModel()->getId()
            );
        }

        $suggestions[] = 'Make sure the gateway supports the requests and there is an action which supports this request (The method returns true).';
        $suggestions[] = 'There may be a bug, so look for a related issue on the issue tracker.';

        return $suggestions;
    }
}
