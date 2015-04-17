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

class NpmFetcher extends AbstractFetcher
{
    /**
     * @var AdapterFactory
     */
    private $adapterFactory;

    /**
     * @var string
     */
    private $packageFileName = 'package.json';

    /**
     * Constructor
     *
     * @param AdapterFactory $adapterFactory
     */
    public function __construct(AdapterFactory $adapterFactory)
    {
        $this->adapterFactory = $adapterFactory;
    }

    /**
     * Fetch the dependencies
     *
     * @param Project $project
     *
     * @return array
     */
    public function fetchDependencies(Project $project)
    {
        $adapter = $this->adapterFactory->createAdapter($project);
        $fileContent = $adapter->getFileContents($this->packageFileName);

        $parsed = $this->parseJson($fileContent);

        if (is_array($parsed)) {
            $dependencies = array();
            if (array_key_exists('dependencies', $parsed)) {
                $dependencies = array_merge($dependencies, $parsed['dependencies']);
            }

            if (array_key_exists('devDependencies', $parsed)) {
                $dependencies = array_merge($dependencies, $parsed['devDependencies']);
            }

            return $dependencies;
        }

        return array();
    }
}
