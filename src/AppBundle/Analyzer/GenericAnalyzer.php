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

class GenericAnalyzer
{
    /**
     * @var AnalyzerFactory
     */
    private $analyzerFactory;

    /**
     * Constructor
     *
     * @param AnalyzerFactory $analyzerFactory
     */
    public function __construct(AnalyzerFactory $analyzerFactory)
    {
        $this->analyzerFactory = $analyzerFactory;
    }

    /**
     * @param Package $package
     * @param string  $manager
     *
     * @return array
     */
    public function analyzePackage(Package $package, $manager)
    {
        $analyzer = $this->analyzerFactory->createForManager($manager);

        return $analyzer->analyzePackage($package);
    }
}
