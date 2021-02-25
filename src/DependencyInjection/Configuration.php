<?php

declare(strict_types=1);

namespace Andante\ReCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('andante_re_captcha');

        //@formatter:off
        /** @var ArrayNodeDefinition $node */
        $node = $treeBuilder->getRootNode();
        $node->children()
                ->scalarNode('secret')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('site_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end();
        //@formatter:on

        return $treeBuilder;
    }
}
