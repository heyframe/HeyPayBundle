<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Security;

interface CryptedInterface
{
    public function decrypt(CypherInterface $cypher);

    public function encrypt(CypherInterface $cypher);
}
