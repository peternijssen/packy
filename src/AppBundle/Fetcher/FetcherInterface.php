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

interface FetcherInterface
{
    /**
     * Get the package file name
     *
     * @return string
     */
    public function getPackageFile();

    /**
     * fetch the dependencies
     *
     * @param string $fileContent
     *
     * @return array
     */
    public function fetchDependencies($fileContent);
}
