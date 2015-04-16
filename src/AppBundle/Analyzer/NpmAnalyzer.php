<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Analyzer;

use AppBundle\Entity\Package;
use GuzzleHttp\Client as GuzzleClient;

class NpmAnalyzer implements AnalyzerInterface
{

    /**
     * @var string
     */
    private $packageVendor = 'https://registry.npmjs.org/';

    /**
     * @param Package $package
     *
     * @return Package
     */
    public function analyzePackage(Package $package)
    {
        $client = new GuzzleClient();
        $response = $client->get(
            $this->packageVendor.$package->getName(),
            array(
                'exceptions' => false,
            )
        );

        if ($response->getStatusCode() == 200) {
            $data = $this->parseJson($response->getBody());

            $newestVersion = $data['dist-tags']['latest'];
            $package->setLatestVersion($newestVersion);
            $package->setLastChecktAt(new \DateTime());
        }

        return $package;
    }

    /**
     * Parse JSON data
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
