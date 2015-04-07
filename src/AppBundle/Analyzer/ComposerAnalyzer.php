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

use AppBundle\Entity\Dependency;
use AppBundle\Entity\Project;
use GuzzleHttp\Client;

/**
 * @TODO: Refactor;
 * Split in multiple, single responsible classes
 * Separate repository checks etc
 */
class ComposerAnalyzer implements AnalyzerInterface
{

    /**
     * @var string
     */
    private $packageVendor = 'https://packagist.org/packages/';

    /**
     * @var string
     */
    private $packageFile = 'composer.lock';

    /**
     * @param Project $project
     *
     * @return array
     */
    public function analyze(Project $project)
    {
        $urlParts = array_filter(explode("/", $project->getRepositoryUrl()));

        $client = new Client();
        $response = $client->get(
            "https://raw.githubusercontent.com/".
            $urlParts[3]
            ."/".
            $urlParts[4]
            ."/master/".
            $this->packageFile
        );
        $lockData = $this->parseJson($response->getBody());

        $dependencies = array();

        if (array_key_exists('packages', $lockData)) {
            foreach ($lockData['packages'] as $package) {
                $client = new Client();
                $response = $client->get($this->packageVendor.$package['name'].".json");
                $data = $this->parseJson($response->getBody());

                $newestVersion = $this->getNewestVersion(array_keys($data['package']['versions']));

                $currentVersion = $this->normalizeVersion($package['version']);

                if (version_compare($currentVersion, $newestVersion) == 0) {
                    $dependency = new Dependency();
                    $dependency->setManager('composer');
                    $dependency->setPackage($package['name']);
                    $dependency->setCurrentVersion($currentVersion);
                    $dependency->setIsUpdate(true);
                    $dependencies[] = $dependency;
                } else {
                    $dependency = new Dependency();
                    $dependency->setManager('composer');
                    $dependency->setPackage($package['name']);
                    $dependency->setCurrentVersion($currentVersion);
                    $dependency->setIsUpdate(false);
                    $dependencies[] = $dependency;
                }
            }
        }

        if (array_key_exists('packages-dev', $lockData)) {
            foreach ($lockData['packages-dev'] as $package) {
                $client = new Client();
                $response = $client->get($this->packageVendor.$package['name'].".json");
                $data = $this->parseJson($response->getBody());

                $newestVersion = $this->getNewestVersion(array_keys($data['package']['versions']));

                $currentVersion = $this->normalizeVersion($package['version']);

                if (version_compare($currentVersion, $newestVersion) == 0) {
                    $dependency = new Dependency();
                    $dependency->setManager('composer');
                    $dependency->setPackage($package['name']);
                    $dependency->setCurrentVersion($currentVersion);
                    $dependency->setIsUpdate(true);
                    $dependencies[] = $dependency;
                } else {
                    $dependency = new Dependency();
                    $dependency->setManager('composer');
                    $dependency->setPackage($package['name']);
                    $dependency->setCurrentVersion($currentVersion);
                    $dependency->setIsUpdate(false);
                    $dependencies[] = $dependency;
                }
            }
        }

        return $dependencies;
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
    private function normalizeVersion($rawVersion)
    {
        // Remove the package link (alpha, RC, beta, etc)
        list($versionCandidate) = explode('-', $rawVersion);
        // Strip the 'v' prefix if exists
        $versionCandidate = str_replace('v', '', $versionCandidate);
        // Transform the ranges
        if (strpos($versionCandidate, ',') !== false) {
            $versionsRange = explode(',', $versionCandidate);
            // Reset the candidate
            $versionCandidate = '0.0.0';
            // Get the higher range
            foreach ($versionsRange as $versionRange) {
                $nowVersion = $this->determineVersionValue($versionRange);
                if (version_compare($versionCandidate, $nowVersion) < 0) {
                    // Range is higher
                    $versionCandidate = $nowVersion;
                }
            }
        } else {
            // Done
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
    public function determineVersionValue($rawVersion)
    {
        // Transform any wildcard into possible highest value
        // and remove any space(s)
        $version = str_replace(array('*', ' '), array('999', ''), $rawVersion);
        // Handle operator
        if (preg_match('/^([\~\>\<\=\!]+)([0-9\.]+)$/', $version, $m) && count($m) == 3) {
            $operator = $m[1];
            $version = $m[2];
            // Hope for the best (finger crossed...)
            $versionAnnotations = explode('.', $version);
            if (count($versionAnnotations) == 3) {
                // Everything ok
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
            // Determine the closest possible value
            if (strpos($operator, '>') !== false || strpos($operator, '!') !== false || strpos($operator, '~') !== false) {
                // Increase the patch and minor version to the max
                $version = $major.'.999.999';
            } elseif (strpos($operator, '<') !== false) {
                // Decrease the patch and minor version to the min
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
