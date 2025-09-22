<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Security;

use HeyPay\Bundle\PayBundle\Core\Registry\StorageRegistryInterface;
use HeyPay\Bundle\PayBundle\Core\Security\AbstractTokenFactory;
use HeyPay\Bundle\PayBundle\Core\Storage\StorageInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TokenFactory extends AbstractTokenFactory
{
    protected UrlGeneratorInterface $urlGenerator;

    public function __construct(StorageInterface $tokenStorage, StorageRegistryInterface $storageRegistry, UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;

        parent::__construct($tokenStorage, $storageRegistry);
    }

    /**
     * @param array<string, mixed> $parameters
     */
    protected function generateUrl($path, array $parameters = []): string
    {
        return $this->urlGenerator->generate($path, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
