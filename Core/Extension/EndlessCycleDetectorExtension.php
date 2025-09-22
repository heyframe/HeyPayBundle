<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Extension;

use HeyPay\Bundle\PayBundle\Core\Exception\LogicException;

class EndlessCycleDetectorExtension implements ExtensionInterface
{
    public function __construct(protected int $limit = 100)
    {
        $this->limit = $limit;
    }

    public function onPreExecute(Context $context): void
    {
        if (\count($context->getPrevious()) >= $this->limit) {
            throw new LogicException(\sprintf(
                'Possible endless cycle detected. ::onPreExecute was called %d times before reach the limit.',
                $this->limit
            ));
        }
    }

    public function onExecute(Context $context): void
    {
    }

    public function onPostExecute(Context $context): void
    {
    }
}
