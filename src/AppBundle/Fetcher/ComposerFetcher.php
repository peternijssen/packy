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

class ComposerFetcher extends AbstractFetcher
{
    /**
     * @var AdapterFactory
     */
    private $adapterFactory;

    /**
     * @var string
     */
    private $packageFileName = 'composer.json';

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
            if (array_key_exists('require', $parsed)) {
                $dependencies = array_merge($dependencies, $parsed['require']);
            }

            if (array_key_exists('require-dev', $parsed)) {
                $dependencies = array_merge($dependencies, $parsed['require-dev']);
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
