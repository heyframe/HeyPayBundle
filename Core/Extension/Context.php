<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Extension;

use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\GatewayInterface;
use HeyPay\Bundle\PayBundle\Core\Reply\ReplyInterface;

class Context
{
    protected ?ActionInterface $action = null;

    protected ?ReplyInterface $reply = null;

    protected ?\Exception $exception = null;

    /**
     * @param Context[] $previous
     */
    public function __construct(
        protected GatewayInterface $gateway,
        protected mixed $request,
        protected array $previous
    ) {
    }

    public function getGateway(): GatewayInterface
    {
        return $this->gateway;
    }

    public function getRequest(): mixed
    {
        return $this->request;
    }

    /**
     * @return Context[]
     */
    public function getPrevious(): array
    {
        return $this->previous;
    }

    public function getAction(): ?ActionInterface
    {
        return $this->action;
    }

    public function setAction(?ActionInterface $action): void
    {
        $this->action = $action;
    }

    public function getReply(): ?ReplyInterface
    {
        return $this->reply;
    }

    public function setReply(?ReplyInterface $reply): void
    {
        $this->reply = $reply;
    }

    public function getException(): ?\Exception
    {
        return $this->exception;
    }

    public function setException(?\Exception $exception): void
    {
        $this->exception = $exception;
    }
}
