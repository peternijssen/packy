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

class Fetchers
{

    /**
     * @var array
     */
    private $fetchers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fetchers = array();
    }

    /**
     * Add a fetcher
     *
     * @param FetcherInterface $fetcher
     */
    public function addFetcher(FetcherInterface $fetcher)
    {
        $this->fetchers[] = $fetcher;
    }

    /**
     * Get the fetchers
     *
     * @return array
     */
    public function getFetchers()
    {
        return $this->fetchers;
    }
}
