<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle;

use HeyPay\Bundle\PayBundle\DependencyInjection\Compiler\BuildConfigsPass;
use HeyPay\Bundle\PayBundle\DependencyInjection\Compiler\BuildGatewayFactoriesBuilderPass;
use HeyPay\Bundle\PayBundle\DependencyInjection\Compiler\BuildGatewayFactoriesPass;
use HeyPay\Bundle\PayBundle\DependencyInjection\Compiler\BuildGatewaysPass;
use HeyPay\Bundle\PayBundle\DependencyInjection\Compiler\BuildStoragesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PayBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new BuildConfigsPass());
        $container->addCompilerPass(new BuildGatewaysPass());
        $container->addCompilerPass(new BuildStoragesPass());
        $container->addCompilerPass(new BuildGatewayFactoriesPass());
        $container->addCompilerPass(new BuildGatewayFactoriesBuilderPass());
    }
}
