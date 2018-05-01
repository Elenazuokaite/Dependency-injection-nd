<?php

namespace Nfq\WeatherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nfq_weather');

        $rootNode
            ->children()
                ->scalarNode('provider')
                    ->isRequired()
                ->end()
                ->arrayNode('providers')
                    ->children()
                        ->arrayNode('openweathermap')
                            ->children()
                                ->scalarNode('api_key')
                                    ->defaultValue('secretapikey')
                                    ->isRequired()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('delegating')
                            ->children()
                                ->arrayNode('providers')
                                    ->scalarPrototype()
                                    ->end()
                                    ->isRequired()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
