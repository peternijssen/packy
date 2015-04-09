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

interface FormatterInterface
{
    /**
     * Get the package file name
     *
     * @return string
     */
    public function getPackageFile();

    /**
     * Format the dependencies
     *
     * @param string $fileContent
     *
     * @return array
     */
    public function formatDependencies($fileContent);
}