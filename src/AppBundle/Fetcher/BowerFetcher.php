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
use AppBundle\Manager\AdapterFactory;

class BowerFetcher extends AbstractFetcher
{
    /**
     * @var string
     */
    protected $packageFileName = 'bower.json';

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
            if (array_key_exists('dependencies', $fileContent)) {
                return $fileContent['dependencies'];
            }
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
        return "bower";
    }
}
