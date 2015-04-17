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

interface AnalyzerInterface
{
    /**
     * @param Package $package
     *
     * @return Package
     */
    public function analyzePackage(Package $package);
}
