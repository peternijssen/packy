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

class Bitbucket implements RepositoryManager
{
    /**
     * @var \Bitbucket\API\Repositories\Src
     */
    private $client;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->client = new \Bitbucket\API\Repositories\Src();
        //$this->client ->setCredentials( new Bitbucket\API\Authentication\Basic($bb_user, $bb_pass) );
    }

    /**
     * Get the file contents.
     *
     *
     * @param Project $project
     * @param string $file
     *
     * @return array
     */
    public function getFileContents(Project $project, string $file): array
    {
        $response = $this->client->raw(
            $project->getVendorName(),
            $project->getPackageName(),
            $project->getBranch(),
            $file
        );

        return $this->parseJson($response->getContent());
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
