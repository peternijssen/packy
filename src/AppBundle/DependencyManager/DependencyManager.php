<?php declare(strict_types=1);

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DependencyManager;

use AppBundle\Entity\Project;
use AppBundle\RepositoryManager\RepositoryManager;

interface DependencyManager
{
    /**
     * Fetch the dependencies.
     *
     * @param RepositoryManager $repositoryManager
     * @param Project           $project
     *
     * @return array
     */
    public function fetchDependencies(RepositoryManager $repositoryManager, Project $project): array;

    /**
     * Get the name of the fetcher.
     *
     * @return string
     */
    public function getName(): string;
}
