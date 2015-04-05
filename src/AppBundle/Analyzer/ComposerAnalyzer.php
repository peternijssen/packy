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
 * @TODO: Refactor
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
        var_dump($urlParts);

        $client = new Client();
        $response = $client->get("https://raw.githubusercontent.com/".$urlParts[3]."/".$urlParts[4]."/master/" . $this->packageFile);
        $lockData = $this->parseJson($response->getBody());

        $dependencies = array();

        if(array_key_exists('packages', $lockData)) {
            foreach ($lockData['packages'] as $package) {
                $client = new Client();
                $response = $client->get($this->packageVendor . $package['name'].".json");
                $data  = $this->parseJson($response->getBody());

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

        if(array_key_exists('packages-dev', $lockData)) {
            foreach ($lockData['packages-dev'] as $package) {
                $client = new Client();
                $response = $client->get($this->packageVendor . $package['name'].".json");
                $data  = $this->parseJson($response->getBody());

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

    private function parseJson($data)
    {
        $parsedData = json_decode($data, true);
        if ($parsedData === false) {
            throw new \RuntimeException('Unable to parse json file');
        }
        return $parsedData;
    }

    private function getNewestVersion($versions = array())
    {
        $latestVersion = 'v0.0.0';
        foreach ($versions as $version) {
            $nowVersion = $this->normalizeVersion($version);
            if (version_compare($latestVersion, $nowVersion) >= 0) {
                continue;
            }
            $latestVersion = $nowVersion;
        }

        return $latestVersion;
    }

    private function normalizeVersion($version)
    {
        return str_replace('v','',$version);
    }
}