<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Bridge\Defuse\Security;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\BadFormatException;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Defuse\Crypto\Key;
use HeyPay\Bundle\PayBundle\Core\Security\CypherInterface;

class DefuseCypher implements CypherInterface
{
    private Key $key;

    /**
     * @throws BadFormatException
     * @throws EnvironmentIsBrokenException
     */
    public function __construct($secret)
    {
        $this->key = Key::loadFromAsciiSafeString($secret);
    }

    /**
     * @throws EnvironmentIsBrokenException
     * @throws WrongKeyOrModifiedCiphertextException
     */
    public function decrypt($value): string
    {
        return Crypto::decrypt($value, $this->key);
    }

    /**
     * @throws EnvironmentIsBrokenException
     */
    public function encrypt($value): string
    {
        return Crypto::encrypt($value, $this->key);
    }
}
