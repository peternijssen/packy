<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class FetcherCompilerPass implements CompilerPassInterface
{
    /**
     * Process compiler
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('packy.fetchers')) {
            return;
        }

        $definition = $container->findDefinition(
            'packy.fetchers'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'packy_fetcher'
        );
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addFetcher',
                array(new Reference($id))
            );
        }
    }
}
