<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Project;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;

class DependencyRepository
{

    /**
     * Entity alias
     *
     * @var string
     */
    const ENTITY_ALIAS = 'd';

    /**
     * Entity to use
     *
     * @var string
     */
    const ENTITY_CLASS = 'AppBundle:Dependency';

    /**
     * Object manager
     *
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * Constructor.
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Find all dependencies for a certain manager
     *
     * @param Project $project
     * @param string  $sortField
     * @param string  $sortOrder
     *
     * @return array
     */
    public function findAllByProject(Project $project, $sortField = 'pa.name', $sortOrder = 'ASC')
    {
        return $this->getQueryBuilder()
            ->leftJoin(self::ENTITY_ALIAS.'.project', 'p')
            ->leftJoin(self::ENTITY_ALIAS.'.package', 'pa')
            ->where('p = :project')
            ->setParameter('project', $project)
            ->orderBy($sortField, $sortOrder)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all dependencies for a certain project and manager
     *
     * @param Project $project
     * @param string  $manager
     * @param string  $sortField
     * @param string  $sortOrder
     *
     * @return array
     */
    public function findAllByManager(Project $project, $manager, $sortField = 'pa.name', $sortOrder = 'ASC')
    {
        return $this->getQueryBuilder()
            ->leftJoin(self::ENTITY_ALIAS.'.project', 'p')
            ->leftJoin(self::ENTITY_ALIAS.'.package', 'pa')
            ->where('p = :project')
            ->andWhere('pa.manager = :manager')
            ->setParameter('project', $project)
            ->setParameter('manager', $manager)
            ->orderBy($sortField, $sortOrder)
            ->getQuery()
            ->getResult();
    }

    /**
     * get QueryBuilder.
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->objectManager
            ->getRepository(self::ENTITY_CLASS)
            ->createQueryBuilder(self::ENTITY_ALIAS);
    }
}
