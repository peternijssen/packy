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

class ComposerAnalyzer implements AnalyzerInterface
{

    /**
     * @var string
     */
    private $packageVendor = 'https://packagist.org/packages/';

    /**
     * @param Package $package
     *
     * @return Package
     */
    public function analyzePackage(Package $package)
    {
        $client = new GuzzleClient();
        $response = $client->get($this->packageVendor.$package->getPackage().".json");
        $data = $this->parseJson($response->getBody());

        $newestVersion = $this->getNewestVersion(array_keys($data['package']['versions']));
        $package->setLatestVersion($newestVersion);
        $package->setLastChecktAt(new \DateTime());

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

    /**
     * Find latest version
     *
     * @param array $versions
     *
     * @return string
     */
    private function getNewestVersion($versions = array())
    {
        $latestVersion = '0.0.0';
        foreach ($versions as $version) {
            $version = ltrim($version, 'v');
            if (preg_match('/^[0-9.]+$/', $version)) {
                if (version_compare($latestVersion, $version) >= 0) {
                    continue;
                }
                $latestVersion = $version;
            }
        }

        return $latestVersion;
    }
}
