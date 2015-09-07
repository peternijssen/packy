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

class GithubAdapter implements AdapterInterface
{
    /**
     * @var \Github\Client
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
        $this->client = new \Github\Client();
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
            $fileContent = $this->client->api('repo')->contents()->download(
                $this->project->getVendorName(),
                $this->project->getPackageName(),
                $file,
                $branch
            );

            return $this->parseJson($fileContent);
        } catch (\Github\Exception\RuntimeException $e) {
            return "";
        }
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
