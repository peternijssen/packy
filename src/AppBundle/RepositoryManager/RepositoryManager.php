<?php declare(strict_types=1);

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\RepositoryManager;

use AppBundle\Entity\Project;

interface RepositoryManager
{
    /**
     * Get the file contents.
     *
     *
     * @param Project $project
     * @param string  $file
     *
     * @return array
     */
    public function getFileContents(Project $project, string $file): array;
}
