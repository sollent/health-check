<?php

namespace sollent\HealthCheckBundle\DependencyInjection\Compiler;

use sollent\HealthCheckBundle\Command\SendDataCommand;
use sollent\HealthCheckBundle\Controller\HealthController;
use sollent\HealthCheckBundle\Service\HealthInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class HealthServicesPath implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(HealthController::class)) {
            return;
        }

        $controller = $container->findDefinition(HealthController::class);
        $command = $container->findDefinition(SendDataCommand::class);
        foreach (array_keys($container->findTaggedServiceIds(HealthInterface::TAG)) as $serviceId) {
            $controller->addMethodCall('addHealthService', [new Reference($serviceId)]);
            $command->addMethodCall('addHealthService', [new Reference($serviceId)]);
        }
    }
}
