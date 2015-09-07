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
        $this->client = new \Gitlab\Client('');
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

            return $this->parseJson($fileContent);
        } catch (\Gitlab\Exception\RuntimeException $e) {
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
        if ($data === false) {
            throw new \RuntimeException('Unable to parse json file');
        }

        if (array_key_exists('content', $data)) {
            return json_decode(base64_decode($data['content']), true);
        }

        return "";
    }
}
