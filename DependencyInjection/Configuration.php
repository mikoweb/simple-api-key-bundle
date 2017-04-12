<?php

/*
 * (c) Rafał Mikołajun <rafal@mikoweb.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\Bundle\SimpleApiKeyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * User Configuration.
 *
 * @author Rafał Mikołajun <rafal@mikoweb.pl>
 * @package mikoweb/simple-api-key-bundle
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mikoweb_simple_api_key');

        $rootNode
            ->children()
                ->scalarNode('user_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('groups')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('roles')
                                ->prototype('scalar')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('keys')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
