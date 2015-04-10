<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

class VersionFormatter
{
    /**
     * Normalize vendor version
     *
     * @param string $rawVersion
     *
     * @return string $version
     */
    public function normalizeVersion($rawVersion)
    {
        $normalizedVersion = "0.0.0";
        if (strpos($rawVersion, ',') !== false) {
            $versionsRange = explode(',', $rawVersion);
            foreach ($versionsRange as $versionRange) {
                $nowVersion = $this->determineVersionValue($versionRange);
                if (version_compare($normalizedVersion, $nowVersion) < 0) {
                    $normalizedVersion = $nowVersion;
                }
            }
        } else {
            $normalizedVersion = $this->determineVersionValue($rawVersion);
        }

        // Remove any characters which don't belong in an actual version number
        $normalizedVersion = preg_replace("/[^0-9.]/", "", $normalizedVersion);

        return $normalizedVersion;
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
