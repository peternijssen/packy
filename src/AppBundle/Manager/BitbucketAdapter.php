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

class BitbucketAdapter implements AdapterInterface
{
    /**
     * @var \Bitbucket\API\Repositories\Src
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
        $this->client = new \Bitbucket\API\Repositories\Src();
        //$this->client ->setCredentials( new Bitbucket\API\Authentication\Basic($bb_user, $bb_pass) );
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
        $response = $this->client->raw(
            $this->project->getVendorName(),
            $this->project->getPackageName(),
            $branch,
            $file
        );

        return $this->parseJson($response->getContent());
    }

    /**
     * Parse JSON data
     *
     * @param string $data
     *
     * @return mixed
     */
    private function parseJson($data)
    {
        $parsedData = json_decode($data, true);
        if ($parsedData === false) {
            throw new \RuntimeException('Unable to parse json file');
        }

        return $parsedData;
    }
}
