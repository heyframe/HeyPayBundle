<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Builder;

use HeyPay\Bundle\PayBundle\Core\Registry\StorageRegistryInterface;
use HeyPay\Bundle\PayBundle\Core\Security\TokenFactoryInterface;
use HeyPay\Bundle\PayBundle\Core\Security\TokenInterface;
use HeyPay\Bundle\PayBundle\Core\Storage\StorageInterface;
use HeyPay\Bundle\PayBundle\Security\TokenFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TokenFactoryBuilder
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function __invoke(): TokenFactoryInterface
    {
        return $this->build(...\func_get_args());
    }

    /**
     * @param StorageInterface<TokenInterface> $tokenStorage
     * @param StorageRegistryInterface<StorageInterface<TokenInterface>> $storageRegistry
     */
    public function build(StorageInterface $tokenStorage, StorageRegistryInterface $storageRegistry): TokenFactoryInterface
    {
        return new TokenFactory($tokenStorage, $storageRegistry, $this->urlGenerator);
    }
}
