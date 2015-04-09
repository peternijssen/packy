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
            $nowVersion = $this->normalizeVersion($version);
            if (version_compare($latestVersion, $nowVersion) >= 0) {
                continue;
            }
            $latestVersion = $nowVersion;
        }

        return $latestVersion;
    }

    /**
     * Normalize vendor version
     *
     * @param string $rawVersion
     *
     * @return string $version
     */
    public function normalizeVersion($rawVersion)
    {
        list($versionCandidate) = explode('-', $rawVersion);
        $versionCandidate = str_replace('v', '', $versionCandidate);
        if (strpos($versionCandidate, ',') !== false) {
            $versionsRange = explode(',', $versionCandidate);
            $versionCandidate = '0.0.0';
            foreach ($versionsRange as $versionRange) {
                $nowVersion = $this->determineVersionValue($versionRange);
                if (version_compare($versionCandidate, $nowVersion) < 0) {
                    $versionCandidate = $nowVersion;
                }
            }
        } else {
            $versionCandidate = $this->determineVersionValue($versionCandidate);
        }

        return $versionCandidate;
    }

    /**
     * Determine version value and handle wildcards and comparison operator
     *
     * @param string $rawVersion
     *
     * @return string $version
     */
    private function determineVersionValue($rawVersion)
    {
        $version = str_replace(array('*', ' '), array('999', ''), $rawVersion);
        if (preg_match('/^([\~\>\<\=\!]+)([0-9\.]+)$/', $version, $m) && count($m) == 3) {
            $operator = $m[1];
            $version = $m[2];
            $versionAnnotations = explode('.', $version);
            if (count($versionAnnotations) == 3) {
                list($major, $minor, $patch) = $versionAnnotations;
            } else {
                switch (count($versionAnnotations)) {
                    case 2:
                        list($major, $minor) = $versionAnnotations;
                        $patch = 999;
                        break;

                    default:
                        $major = $versionAnnotations;
                        $minor = 999;
                        $patch = 999;
                        break;
                }
            }
            if (strpos($operator, '>') !== false || strpos($operator, '!') !== false || strpos($operator, '~') !== false) {
                $version = $major.'.999.999';
            } elseif (strpos($operator, '<') !== false) {
                if ($major == 0 && $minor > 0) {
                    $version = $major.'.'.(((int) $minor) - 1).'.999';
                } elseif ($patch == 0) {
                    $version = (((int) $major) - 1).'.999.999';
                } else {
                    $version = $major.'.0.0';
                }
            }
        }

        return $version;
    }
}
