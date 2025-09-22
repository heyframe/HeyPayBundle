<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpExceptionInterface extends ExceptionInterface
{
    public function setRequest(RequestInterface $request);

    public function getRequest(): RequestInterface;

    public function setResponse(ResponseInterface $response);

    public function getResponse(): ResponseInterface;
}
