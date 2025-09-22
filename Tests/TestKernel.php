<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Tests;

use HeyPay\Bundle\PayBundle\PayBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new PayBundle(),
        ];
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/HeyPayBundle/logs';
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/HeyPayBundle/cache';
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/config.yml');
    }

    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }
}
