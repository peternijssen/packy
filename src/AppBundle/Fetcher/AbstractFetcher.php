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

abstract class AbstractFetcher implements FetcherInterface
{
    /**
     * @var string
     */
    protected $packageFileName = '';

    /**
     * @var AdapterFactory
     */
    private $adapterFactory;

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
     * Fetch the file content
     *
     * @param Project $project
     *
     * @return string
     */
    protected function fetchFileContent(Project $project)
    {
        $adapter = $this->adapterFactory->createAdapter($project);
        $fileContent = $adapter->getFileContents($this->packageFileName, $project->getBranch());

        return $fileContent;
    }
}
