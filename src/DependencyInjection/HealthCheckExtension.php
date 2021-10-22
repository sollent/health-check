<?php

namespace sollent\HealthCheckBundle\DependencyInjection;

use sollent\HealthCheckBundle\Command\SendDataCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HealthCheckExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $commandDefinition = new Definition(SendDataCommand::class);
        foreach ($configs['senders'] as $serviceId) {
            $commandDefinition->addArgument(new Reference($serviceId));
        }
        $commandDefinition->addTag('console.command', ['command' => SendDataCommand::COMMAND_NAME]);
        $container->setDefinition(SendDataCommand::class, $commandDefinition);
    }
}
