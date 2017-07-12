<?php declare(strict_types=1);

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RepositoryManagerCompilerPass implements CompilerPassInterface
{
    /**
     * Process compiler.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('packy.repository_managers')) {
            return;
        }

        $definition = $container->findDefinition('packy.repository_managers');

        $taggedServices = $container->findTaggedServiceIds('packy_repository_manager');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('add', [new Reference($id), $attributes["alias"]]);
            }
        }
    }
}
