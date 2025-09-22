<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Model;

use HeyPay\Bundle\PayBundle\Core\Security\TokenInterface;
use HeyPay\Bundle\PayBundle\Core\Security\Util\Random;
use HeyPay\Bundle\PayBundle\Core\Storage\IdentityInterface;

class Token implements TokenInterface
{
    protected IdentityInterface $details;

    protected string $hash;

    protected string $afterUrl;

    protected string $targetUrl;

    protected string $gatewayName;

    public function __construct()
    {
        $this->hash = Random::generateToken();
    }

    public function getDetails(): Identity
    {
        return $this->details;
    }

    public function setDetails(iterable $details): void
    {
        if ($details instanceof IdentityInterface) {
            $this->details = $details;
        }
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    public function getTargetUrl(): string
    {
        return $this->targetUrl;
    }

    public function setTargetUrl($targetUrl): void
    {
        $this->targetUrl = $targetUrl;
    }

    public function getAfterUrl(): string
    {
        return $this->afterUrl;
    }

    public function setAfterUrl($afterUrl): void
    {
        $this->afterUrl = $afterUrl;
    }

    public function getGatewayName(): string
    {
        return $this->gatewayName;
    }

    public function setGatewayName($gatewayName): void
    {
        $this->gatewayName = $gatewayName;
    }
}
