<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Bridge\PlainPhp\Action;

use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\Exception\RequestNotSupportedException;
use HeyPay\Bundle\PayBundle\Core\Request\GetHttpRequest;

class GetHttpRequestAction implements ActionInterface
{
    /**
     * @param GetHttpRequest $request
     */
    public function execute(mixed $request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $request->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $request->query = $_GET;
        $request->request = $_REQUEST;
        $request->clientIp = $_SERVER['REMOTE_ADDR'] ?? '';
        $request->uri = $_SERVER['REQUEST_URI'] ?? '';
        $request->userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $request->content = file_get_contents('php://input');
    }

    public function supports(mixed $request): bool
    {
        return $request instanceof GetHttpRequest;
    }
}
