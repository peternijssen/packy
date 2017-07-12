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

class Github implements RepositoryManager
{
    /**
     * @var \Github\Client
     */
    private $client;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->client = new \Github\Client();
    }

    /**
     * Get the file contents.
     *
     *
     * @param Project $project
     * @param string  $file
     *
     * @return array
     */
    public function getFileContents(Project $project, string $file): array
    {
        try {
            $fileContent = $this->client->api('repo')->contents()->download(
                $project->getVendorName(),
                $project->getPackageName(),
                $file,
                $project->getBranch()
            );

            return $this->parseJson($fileContent);
        } catch (\Github\Exception\RuntimeException $e) {
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
        $parsedData = json_decode($data, true);
        if ($parsedData === false) {
            throw new \RuntimeException('Unable to parse json file');
        }

        return $parsedData;
    }
}
