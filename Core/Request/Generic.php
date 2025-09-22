<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Request;

use HeyPay\Bundle\PayBundle\Core\Model\ModelAggregateInterface;
use HeyPay\Bundle\PayBundle\Core\Model\ModelAwareInterface;
use HeyPay\Bundle\PayBundle\Core\Storage\IdentityInterface;

abstract class Generic implements ModelAwareInterface, ModelAggregateInterface
{
    protected mixed $firstModel = null;

    public function __construct(
        protected mixed $model,
    ) {
    }

    public function getModel(): mixed
    {
        return $this->model;
    }

    public function setModel(mixed $model): void
    {
        if (\is_array($model)) {
            $model = new \ArrayObject($model);
        }

        $this->model = $model;

        $this->setFirstModel($model);
    }

    protected function setFirstModel(mixed $model): void
    {
        if ($this->firstModel) {
            return;
        }

        if ($model instanceof IdentityInterface) {
            return;
        }

        $this->firstModel = $model;
    }
}
