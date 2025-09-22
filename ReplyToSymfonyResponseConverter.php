<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle;

use HeyPay\Bundle\PayBundle\Core\Exception\LogicException;
use HeyPay\Bundle\PayBundle\Core\Reply\HttpResponse;
use HeyPay\Bundle\PayBundle\Core\Reply\ReplyInterface;
use HeyPay\Bundle\PayBundle\Reply\HttpResponse as SymfonyHttpResponse;
use Symfony\Component\HttpFoundation\Response;

class ReplyToSymfonyResponseConverter
{
    public function convert(ReplyInterface $reply): Response
    {
        if ($reply instanceof SymfonyHttpResponse) {
            return $reply->getResponse();
        }

        if ($reply instanceof HttpResponse) {
            $headers = $reply->getHeaders();
            $headers['X-Status-Code'] = $reply->getStatusCode();

            return new Response($reply->getContent(), $reply->getStatusCode(), $headers);
        }

        $ro = new \ReflectionObject($reply);

        throw new LogicException(
            \sprintf('Cannot convert reply %s to http response.', $ro->getShortName()),
            0,
            $reply
        );
    }
}
