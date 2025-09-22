<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core;

use HeyPay\Bundle\PayBundle\Core\Action\ActionInterface;
use HeyPay\Bundle\PayBundle\Core\Exception\RequestNotSupportedException;
use HeyPay\Bundle\PayBundle\Core\Extension\Context;
use HeyPay\Bundle\PayBundle\Core\Extension\ExtensionCollection;
use HeyPay\Bundle\PayBundle\Core\Extension\ExtensionInterface;
use HeyPay\Bundle\PayBundle\Core\Reply\ReplyInterface;

class Gateway implements GatewayInterface
{
    /**
     * @var list<class-string<ActionInterface>|ActionInterface>
     */
    protected array $actions = [];

    protected ExtensionCollection $extensions;

    /**
     * @var Context[]
     */
    protected array $stack = [];

    public function __construct()
    {
        $this->extensions = new ExtensionCollection();
    }

    public function execute(mixed $request, bool $catchReply = false): ?ReplyInterface
    {
        $context = new Context($this, $request, $this->stack);

        $this->stack[] = $context;

        try {
            $this->extensions->onPreExecute($context);

            if (!$context->getAction()) {
                if (!$action = $this->findActionSupported($context->getRequest())) {
                    throw RequestNotSupportedException::create($context->getRequest());
                }

                $context->setAction($action);
            }

            $this->extensions->onExecute($context);

            $context->getAction()->execute($request);

            $this->extensions->onPostExecute($context);

            array_pop($this->stack);
        } catch (ReplyInterface $reply) {
            $context->setReply($reply);

            $this->extensions->onPostExecute($context);

            array_pop($this->stack);

            if ($catchReply && $context->getReply()) {
                return $context->getReply();
            }

            if ($context->getReply()) {
                throw $context->getReply();
            }
        } catch (\Exception $e) {
            $context->setException($e);

            $this->onPostExecuteWithException($context);
        }

        return null;
    }

    public function addAction(ActionInterface $action, bool $forcePrepend = false): void
    {
        $forcePrepend ?
            array_unshift($this->actions, $action) :
            array_push($this->actions, $action);
    }

    public function addExtension(ExtensionInterface $extension, bool $forcePrepend = false): void
    {
        $this->extensions->addExtension($extension, $forcePrepend);
    }

    /**
     * @throws \Throwable
     */
    protected function onPostExecuteWithException(Context $context): void
    {
        array_pop($this->stack);

        $exception = $context->getException();

        try {
            $this->extensions->onPostExecute($context);
        } catch (\Exception $e) {
            // logic is similar to one in Symfony's ExceptionListener::onKernelException
            $wrapper = $e;
            while (($prev = $wrapper->getPrevious()) !== null) {
                if ($prev === $exception) {
                    throw $e;
                }
                $wrapper = $prev;
            }

            function wrapPrevious(\Throwable $wrapper, \Throwable $previous): \Throwable
            {
                return new \Exception($wrapper->getMessage(), $wrapper->getCode(), $previous);
            }

            $wrapper = $e;
            $chain = $exception;
            $stack = [];
            while (($prev = $wrapper->getPrevious()) !== null) {
                $stack[] = $prev;
                $wrapper = $prev;
            }

            foreach (array_reverse($stack) as $ex) {
                $chain = wrapPrevious($ex, $chain);
            }

            throw wrapPrevious($e, $chain);
        }

        if ($context->getException()) {
            throw $context->getException();
        }
    }

    protected function findActionSupported(mixed $request): ?ActionInterface
    {
        foreach ($this->actions as $action) {
            if ($action instanceof GatewayAwareInterface) {
                $action->setGateway($this);
            }
            if ($action->supports($request)) {
                return $action;
            }
        }

        return null;
    }
}
