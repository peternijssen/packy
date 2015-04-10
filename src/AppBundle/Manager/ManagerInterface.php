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
use AppBundle\Fetcher\FetcherInterface;

interface ManagerInterface
{
    /**
     * Get dependencies for package file
     *
     * @param Project          $project
     * @param FetcherInterface $fetcher
     *
     * @return array
     */
    public function getDependencies(Project $project, FetcherInterface $fetcher);
}
