<?php

namespace Adldap2Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        //TODO: Define basic configuration
        $treeBuilder = new TreeBuilder('adldap2');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->arrayNode('config')
                    ->children()
                        ->scalarNode('account_suffix')->end()
                        ->arrayNode('hosts')
                            ->isRequired()
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('port')->end()
                        ->scalarNode('base_dn')->end()
                        ->scalarNode('username')->end()
                        ->scalarNode('password')->end()
                        ->scalarNode('account_suffix')->end()
                        ->booleanNode('follow_referrals')->end()
                        ->booleanNode('use_ssl')->end()
                        ->booleanNode('use_tls')->end()
                        ->scalarNode('client_secret')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
