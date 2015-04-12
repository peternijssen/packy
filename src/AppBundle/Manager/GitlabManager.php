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
use AppBundle\Fetcher\FetcherInterface;
use GuzzleHttp\Client as GuzzleClient;

/**
 * TODO: Gitlab URL should be configurable
 * TODO: Gitlab requires a ?private_token and should be configurable
 */
class GitlabManager implements ManagerInterface
{
    /**
     * Get dependencies for package file
     *
     * @param Project          $project
     * @param FetcherInterface $fetcher
     *
     * @return array
     */
    public function getDependencies(Project $project, FetcherInterface $fetcher)
    {
        $urlParts = array_filter(explode("/", $project->getRepositoryUrl()));

        $client = new GuzzleClient();
        $response = $client->get(
            "https://gitlab.com/api/v3/projects/".$urlParts[3]."%2F".$urlParts[4]."/repository/files/?private_token=TODO&file_path=".$fetcher->getPackageFile()."&ref=master",
            array(
                'exceptions' => false,
            )
        );

        if ($response->getStatusCode() == 200) {
            $body = $this->parseJson($response->getBody());

            return $fetcher->fetchDependencies($body);
        }

        return array();
    }

    /**
     * Parse JSON data
     *
     * @param string $data
     *
     * @return string
     */
    protected function parseJson($data)
    {
        $parsedData = json_decode($data, true);
        if ($parsedData === false) {
            throw new \RuntimeException('Unable to parse json file');
        }

        return $parsedData;
    }
}
