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

class ProjectRepository
{
    /**
     * Entity alias.
     *
     * @var string
     */
    const ENTITY_ALIAS = 'p';

    /**
     * Entity to use.
     *
     * @var string
     */
    const ENTITY_CLASS = 'AppBundle:Project';

    /**
     * Object manager.
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
     * Find all projects.
     *
     * @param string $sortField
     * @param string $sortOrder
     *
     * @return Project[]
     */
    public function findAll($sortField = 'createdAt', $sortOrder = 'DESC')
    {
        return $this->getQueryBuilder()
            ->orderBy(self::ENTITY_ALIAS . '.' . $sortField, $sortOrder)
            ->getQuery()
            ->getResult();
    }

    /**
     * Create a project.
     *
     * @param Project $project
     */
    public function create(Project $project)
    {
        $this->objectManager->persist($project);
        $this->objectManager->flush();
    }

    /**
     * Update a project.
     *
     * @param Project $project
     */
    public function update(Project $project)
    {
        $this->objectManager->persist($project);
        $this->objectManager->flush();
    }

    /**
     * Delete a project.
     *
     * @param Project $project
     */
    public function delete(Project $project)
    {
        $this->objectManager->remove($project);
        $this->objectManager->flush();
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
