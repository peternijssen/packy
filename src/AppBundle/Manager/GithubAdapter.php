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


class GithubAdapter implements AdapterInterface
{
    /**
     * @var \Github\Client
     */
    private $client;

    /**
     * Constructor
     */
    public function __construct()
    {
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
            $fileContent = $this->client->api('repo')->contents()->download("PROJECT_ID", "PROJECT_ID", $file, $branch);

            return $fileContent;
        } catch (\Github\Exception\RuntimeException $e) {
            return "";
        }
    }
}
