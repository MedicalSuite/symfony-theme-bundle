<?php
namespace Velarde\SymfonyThemeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $tree = new TreeBuilder('velarde_symfony_theme');
        $root = $tree->getRootNode();

        $root->children()
            ->scalarNode('base_layout')
            ->isRequired()
            ->end();

        $root->children()
            ->scalarNode('widget_directory')->isRequired()->end();

        return $tree;
    }

}