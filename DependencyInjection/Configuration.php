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
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('adldap2');
        $rootNode
            ->children()
                ->arrayNode('config')
                    ->children()
                        ->scalarNode('account_suffix')->end()
                        ->arrayNode('domain_controllers')
                            ->isRequired()
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('port')->end()
                        ->scalarNode('base_dn')->end()
                        ->scalarNode('admin_username')->end()
                        ->scalarNode('admin_password')->end()
                        ->scalarNode('admin_account_suffix')->end()
                        ->booleanNode('follow_referrals')->end()
                        ->booleanNode('use_ssl')->end()
                        ->booleanNode('use_tls')->end()
                        ->booleanNode('use_sso')->end()
                        ->scalarNode('client_secret')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
