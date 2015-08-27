<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Fetcher;

use AppBundle\Entity\Project;

class ComposerFetcher extends AbstractFetcher
{
    /**
     * @var string
     */
    protected $packageFileName = 'composer.json';

    /**
     * Fetch the dependencies
     *
     * @param Project $project
     *
     * @return array
     */
    public function fetchDependencies(Project $project)
    {
        $fileContent = $this->fetchFileContent($project);

        if (is_array($fileContent)) {
            $dependencies = array();
            if (array_key_exists('require', $fileContent)) {
                $dependencies = array_merge($dependencies, $fileContent['require']);
            }

            if (array_key_exists('require-dev', $fileContent)) {
                $dependencies = array_merge($dependencies, $fileContent['require-dev']);
            }
            unset($dependencies['php']);

            return $dependencies;
        }

        return array();
    }

    /**
     * Get the name of the fetcher
     *
     * @return string
     */
    public function getName()
    {
        return "composer";
    }
}
