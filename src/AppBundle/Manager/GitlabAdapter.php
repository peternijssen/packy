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

use AppBundle\Service\SettingsService;

class GitlabAdapter implements AdapterInterface
{
    /**
     * @var \Gitlab\Client
     */
    private $client;

    /**
     * Constructor
     *
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->client = new \Gitlab\Client($settingsService->getValue('gitlab_url').'/api/v3/');
        $this->client->authenticate($settingsService->getValue('gitlab_token'), \Gitlab\Client::AUTH_URL_TOKEN);
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
            $fileContent = $this->client->api('repositories')->getFile("PROJECT_ID", $file, $branch);

            return $fileContent;
        } catch (\Gitlab\Exception\RuntimeException $e) {
            return "";
        }
    }
}
