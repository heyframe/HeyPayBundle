<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Security;

interface CypherInterface
{
    /**
     * This method decrypts the passed value.
     */
    public function decrypt(string $value): string;

    /**
     * This method encrypts the passed value.
     *
     * Binary data may be base64-encoded.
     */
    public function encrypt(string $value): string;
}
