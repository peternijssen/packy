<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Project;
use AppBundle\Formatter\FormatterInterface;

class GenericManager
{
    /**
     * @var ManagerFactory
     */
    private $managerFactory;

    /**
     * Constructor
     *
     * @param ManagerFactory $managerFactory
     */
    public function __construct(ManagerFactory $managerFactory)
    {
        $this->managerFactory = $managerFactory;
    }

    /**
     * Get depencies
     *
     * @param Project            $project
     * @param FormatterInterface $formatter
     *
     * @return array
     */
    public function getDependencies(Project $project, FormatterInterface $formatter)
    {
        $analyzer = $this->managerFactory->createForManager($project);

        return $analyzer->getDependencies($project, $formatter);
    }
}
