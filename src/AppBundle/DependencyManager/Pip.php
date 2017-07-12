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

class Pip implements DependencyManager
{
    /**
     * @var string
     */
    private $packageFileName;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->packageFileName = 'requirements.txt';
    }

    /**
     * Fetch the dependencies.
     *
     * @param RepositoryManager $repositoryManager
     * @param Project           $project
     *
     * @return array
     */
    public function fetchDependencies(RepositoryManager $repositoryManager, Project $project): array
    {
        $fileContent = $repositoryManager->getFileContents($project, $this->packageFileName);

        if (is_array($fileContent) && !empty($fileContent)) {
            $lines = explode("\n", $fileContent);

            $dependencies = [];
            foreach ($lines as $line) {
                $chunks = explode('==', $line);
                if (count($chunks) == 2) {
                    $dependencies[$chunks[0]] = $chunks[1];
                }
            }

            return $dependencies;
        }

        return [];
    }

    /**
     * Get the name of the fetcher.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'pip';
    }
}
