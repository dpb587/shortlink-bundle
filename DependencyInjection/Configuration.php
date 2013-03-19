<?php

namespace DPB\Bundle\ShortlinkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $builder->root('dpb_shortlink')
            ->children()
                ->scalarNode('root')
                    ->info('Redirection URL when accessing / (or null to return a 404)')
                    ->defaultNull()
                    ->end()
                ->arrayNode('link')
                    ->info('Options for generating short links')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('characters')
                            ->info('Character set to use for auto-generated short codes')
                            ->defaultValue('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
                            ->end()
                        ->integerNode('default_length')
                            ->info('Length of auto-generated short codes')
                            ->defaultValue(6)
                            ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }
}
