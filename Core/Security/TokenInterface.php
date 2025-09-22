<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Security;

use HeyPay\Bundle\PayBundle\Core\Model\DetailsAggregateInterface;
use HeyPay\Bundle\PayBundle\Core\Model\DetailsAwareInterface;
use HeyPay\Bundle\PayBundle\Core\Storage\IdentityInterface;

/**
 * @method IdentityInterface getDetails()
 */
interface TokenInterface extends DetailsAggregateInterface, DetailsAwareInterface
{
    public function getHash(): string;

    public function setHash(string $hash): void;

    public function getTargetUrl(): string;

    public function setTargetUrl(string $targetUrl): void;

    public function getAfterUrl(): string;

    public function setAfterUrl(string $afterUrl): void;

    public function getGatewayName(): string;

    public function setGatewayName(string $gatewayName): void;
}
