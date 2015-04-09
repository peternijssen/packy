<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Formatter;

class ComposerFormatter extends AbstractFormatter
{
    /**
     * @var string
     */
    private $packageFileName = 'composer.json';

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
     * Format the dependencies
     *
     * @param string $fileContent
     *
     * @return array
     */
    public function formatDependencies($fileContent)
    {
        if (array_key_exists('content', $fileContent)) {
            $decoded = $this->parseJson(base64_decode($fileContent['content']));

            $dependencies = array_merge($decoded['require'], $decoded['require-dev']);
            unset($dependencies['php']);

            return $dependencies;
        }

        return array();
    }
}
