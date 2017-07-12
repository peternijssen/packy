<?php declare(strict_types=1);

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\RepositoryManager;

use AppBundle\Entity\Project;

class Gitlab implements RepositoryManager
{
    /**
     * @var \Gitlab\Client
     */
    private $client;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->client = new \Gitlab\Client('');
        $this->client->authenticate('', \Gitlab\Client::AUTH_URL_TOKEN);
    }

    /**
     * Get the file contents.
     *
     * @param Project $project
     * @param string  $file
     *
     * @return array
     */
    public function getFileContents(Project $project, string $file): array
    {
        try {
            $fileContent = $this->client->api('repositories')->getFile(
                $project->getVendorName() . '/' . $project->getPackageName(),
                $file,
                $project->getBranch()
            );

            return $this->parseJson($fileContent);
        } catch (\Gitlab\Exception\RuntimeException $e) {
            return [];
        }
    }

    /**
     * Parse JSON data.
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

        return '';
    }
}
