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

class PipFetcher extends AbstractFetcher
{
    /**
     * @var AdapterFactory
     */
    private $adapterFactory;

    /**
     * @var string
     */
    private $packageFileName = 'requirements.txt';

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

        $lines = explode("\n", $fileContent);

        $dependencies = array();
        foreach ($lines as $line) {
            $chunks = explode("==", $line);
            if (count($chunks) == 2) {
                $dependencies[$chunks[0]] = $chunks[1];
            }
        }

        return $dependencies;
    }

    /**
     * Get the name of the fetcher
     *
     * @return string
     */
    public function getName()
    {
        return "pip";
    }
}
