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
     * @var AdapterFactory
     */
    private $adapterFactory;

    /**
     * @var string
     */
    private $packageFileName = 'bower.json';

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
            if (array_key_exists('dependencies', $parsed)) {
                return $parsed['dependencies'];
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
