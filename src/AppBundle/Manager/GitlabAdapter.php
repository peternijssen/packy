<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Project;

class GitlabAdapter implements AdapterInterface
{
    /**
     * @var \Gitlab\Client
     */
    private $client;

    /**
     * @var Project
     */
    private $project;

    /**
     * Constructor
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->client = new \Gitlab\Client('/api/v3/');
        $this->client->authenticate("", \Gitlab\Client::AUTH_URL_TOKEN);
    }

    /**
     * Get the file contents
     *
     * @param string $file
     * @param string $branch
     *
     * @return string
     */
    public function getFileContents($file, $branch = 'master')
    {
        try {
            $fileContent = $this->client->api('repositories')->getFile(
                $this->project->getVendorName()."/".$this->project->getPackageName(),
                $file,
                $branch
            );

            return $fileContent;
        } catch (\Gitlab\Exception\RuntimeException $e) {
            return "";
        }
    }
}
