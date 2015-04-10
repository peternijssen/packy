<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Fetcher;

class NpmFetcher extends AbstractFetcher
{
    /**
     * @var string
     */
    private $packageFileName = 'package.json';

    /**
     * Get the package file name
     *
     * @return string
     */
    public function getPackageFile()
    {
        return $this->packageFileName;
    }

    /**
     * Fetch the dependencies
     *
     * @param string $fileContent
     *
     * @return array
     */
    public function fetchDependencies($fileContent)
    {
        if (array_key_exists('content', $fileContent)) {
            $decoded = $this->parseJson(base64_decode($fileContent['content']));

            $dependencies = array_merge($decoded['dependencies'], $decoded['devDependencies']);

            return $dependencies;
        }

        return array();
    }
}
