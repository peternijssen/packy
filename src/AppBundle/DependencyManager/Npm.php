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

class Npm implements DependencyManager
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
        $this->packageFileName = 'package-lock.json';
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

        if (is_array($fileContent)) {
            $dependencies = [];
            if (array_key_exists('dependencies', $fileContent)) {
                foreach ($fileContent['dependencies'] as $name => $package) {
                    $dependencies[$name] = $package['version'];
                }
            }

            if (array_key_exists('devDependencies', $fileContent)) {
                foreach ($fileContent['devDependencies'] as $name => $package) {
                    $dependencies[$name] = $package['version'];
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
        return 'npm';
    }
}
