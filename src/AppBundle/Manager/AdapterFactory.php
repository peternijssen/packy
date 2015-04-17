<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Project;

class AdapterFactory
{
    /**
     * Create for manager
     *
     * @param Project $project
     *
     * @return AdapterInterface
     */
    public function createAdapter(Project $project)
    {
        $className = ucfirst($project->getRepositoryType())."Adapter";

        if (class_exists($className)) {
            return new $className($project);
        }

        throw new \InvalidArgumentException('Unknown adapter: '.$project->getRepositoryType());
    }
}
