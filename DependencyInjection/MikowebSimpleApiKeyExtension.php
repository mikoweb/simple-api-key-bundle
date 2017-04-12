<?php

/*
 * (c) Rafał Mikołajun <rafal@mikoweb.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\Bundle\SimpleApiKeyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * SimpleApiKey Extension.
 *
 * @author Rafał Mikołajun <rafal@mikoweb.pl>
 * @package mikoweb/simple-api-key-bundle
 */
class MikowebSimpleApiKeyExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('mikoweb_simple_api_key.groups', $config['groups']);
        $container->setParameter('mikoweb_simple_api_key.keys', $config['keys']);
        $container->setParameter('mikoweb_simple_api_key.user_class', $config['user_class']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
