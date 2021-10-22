<?php

namespace sollent\HealthCheckBundle;

use sollent\HealthCheckBundle\DependencyInjection\Compiler\HealthServicesPath;
use sollent\HealthCheckBundle\Service\HealthInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HealthCheckBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new HealthServicesPath());
        $container->registerForAutoconfiguration(HealthInterface::class)->addTag(HealthInterface::TAG);
    }
}
