<?php

namespace AdamWojs\SymfonyConfigGenBundle\Tests\Configuration\Fixtures;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @source \Symfony\Component\Config\Tests\Fixtures\Configuration\ExampleConfiguration
 */
final class ExampleConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('acme_root');

        $treeBuilder->getRootNode()
            ->fixXmlConfig('parameter')
            ->fixXmlConfig('connection')
            ->fixXmlConfig('cms_page')
            ->children()
                ->booleanNode('boolean')->defaultTrue()->end()
                ->scalarNode('scalar_empty')->end()
                ->scalarNode('scalar_null')->defaultNull()->end()
                ->scalarNode('scalar_true')->defaultTrue()->end()
                ->scalarNode('scalar_false')->defaultFalse()->end()
                ->scalarNode('scalar_default')->defaultValue('default')->end()
                ->scalarNode('scalar_array_empty')->defaultValue([])->end()
                ->scalarNode('scalar_array_defaults')->defaultValue(['elem1', 'elem2'])->end()
                ->scalarNode('scalar_required')->isRequired()->end()
                ->enumNode('enum_with_default')->values(['this', 'that'])->defaultValue('this')->end()
                ->enumNode('enum')->values(['this', 'that'])->end()
                ->arrayNode('array')
                    ->info('some info')
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('child1')->end()
                        ->scalarNode('child2')->end()
                        ->scalarNode('child3')
                            ->info(
                                "this is a long\n" .
                                "multi-line info text\n" .
                                'which should be indented'
                            )
                            ->example('example setting')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('scalar_prototyped')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('scalar_prototyped')
                    ->prototype('scalar')->end()
                    ->example(['foo', 'bar', 'baz'])
                ->end()
                ->arrayNode('parameters')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->info('Parameter name')->end()
                ->end()
                ->arrayNode('connections')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('user')->end()
                            ->scalarNode('pass')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('cms_pages')
                    ->useAttributeAsKey('page')
                    ->prototype('array')
                        ->useAttributeAsKey('locale')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('title')->isRequired()->end()
                                ->scalarNode('path')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('pipou')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('didou')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
