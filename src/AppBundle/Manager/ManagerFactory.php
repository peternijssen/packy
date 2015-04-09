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

class ManagerFactory
{
    /**
     * Create for manager
     *
     * @param Project $project
     *
     * @return ManagerInterface
     */
    public function createForManager(Project $project)
    {
        if (strpos($project->getRepositoryUrl(), 'github') !== false) {
            return new GithubManager();
        }

        throw new \InvalidArgumentException('Unknown repository manager for : '.$project->getRepositoryUrl());
    }
}
