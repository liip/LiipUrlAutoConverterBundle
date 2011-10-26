<?php

namespace Liip\UrlAutoConverterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('liip_url_auto_converter');

        $rootNode
            ->children()
                ->scalarNode('linkclass')->defaultValue('')->end()
                ->scalarNode('target')->defaultValue('_blank')->end()
                ->scalarNode('debugmode')->defaultFalse()->end()
            ->end();

        return $treeBuilder;
    }
}
