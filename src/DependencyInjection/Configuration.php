<?php

namespace Hgabka\KunstmaanPopupBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Configuration implements ConfigurationInterface
{
    /** @var ContainerBuilder */
    private $container;

    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('hgabka_kunstmaan_popup');
        $rootNode
                ->children()
                    ->scalarNode('editor_role')->cannotBeEmpty()->defaultValue('ROLE_POPUP_ADMIN')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
