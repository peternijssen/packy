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

class Composer implements DependencyManager
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
        $this->packageFileName = 'composer.lock';
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
            if (array_key_exists('packages', $fileContent)) {
                foreach ($fileContent['packages'] as $package) {
                    $dependencies[$package['name']] = $package['version'];
                }
            }

            if (array_key_exists('packages-dev', $fileContent)) {
                foreach ($fileContent['packages'] as $package) {
                    $dependencies[$package['name']] = $package['version'];
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
        return 'composer';
    }
}
