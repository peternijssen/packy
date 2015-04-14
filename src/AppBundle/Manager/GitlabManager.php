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
use AppBundle\Service\SettingsService;
use GuzzleHttp\Client as GuzzleClient;

class GitlabManager implements ManagerInterface
{
    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * Constructor
     *
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

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

        dump($this->settingsService->getValue('gitlab_url', 'https://gitlab.com')."/api/v3/projects/".$urlParts[3]."%2F".$urlParts[4]."/repository/files/?private_token=".$this->settingsService->getValue('gitlab_token', 'none')."&file_path=".$fetcher->getPackageFile()."&ref=master");

        $client = new GuzzleClient();
        $response = $client->get(
            $this->settingsService->getValue('gitlab_url', 'https://gitlab.com')."/api/v3/projects/".$urlParts[3]."%2F".$urlParts[4]."/repository/files/?private_token=".$this->settingsService->getValue('gitlab_token', 'none')."&file_path=".$fetcher->getPackageFile()."&ref=master",
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
