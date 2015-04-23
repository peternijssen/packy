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

class BowerAnalyzer implements AnalyzerInterface
{

    /**
     * @var string
     */
    private $packageVendor = 'https://bower.herokuapp.com/packages/';

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
            $data = $this->parseJson((string) $response->getBody());

            // TODO: Handle this differently
            $urlChunks = explode("/", $data['url']);
            $githubClient = new \Github\Client();
            $tags = $githubClient->api('repo')->tags($urlChunks[3], substr($urlChunks[4], 0, -4));


            $newestVersion = $this->getLatestVersion(array_column($tags, 'name'));
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

    /**
     * Find latest version
     *
     * @param array $versions
     *
     * @return string
     */
    private function getLatestVersion($versions = array())
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
