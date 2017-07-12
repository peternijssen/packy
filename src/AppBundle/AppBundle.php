<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle;

use AppBundle\DependencyInjection\Compiler\DependencyManagerCompilerPass;
use AppBundle\DependencyInjection\Compiler\RepositoryManagerCompilerPass;
use AppBundle\DependencyInjection\Compiler\PackageManagerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DependencyManagerCompilerPass());
        $container->addCompilerPass(new RepositoryManagerCompilerPass());
        $container->addCompilerPass(new PackageManagerCompilerPass());
    }
}
