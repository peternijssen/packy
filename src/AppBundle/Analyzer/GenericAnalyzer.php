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

use AppBundle\Entity\Project;

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
     * @param Project $project
     * @param string  $manager
     *
     * @return array
     */
    public function analyzeForManager(Project $project, $manager)
    {
        $analyzer = $this->analyzerFactory->createForManager($manager);

        return $analyzer->analyze($project);
    }
}