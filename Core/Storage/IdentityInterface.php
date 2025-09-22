<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Storage;

interface IdentityInterface extends \Serializable
{
    public function getClass(): string;

    public function getId(): mixed;
}
