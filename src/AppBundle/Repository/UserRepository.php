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

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;

class UserRepository
{
    /**
     * Entity alias
     *
     * @var string
     */
    const ENTITY_ALIAS = 'u';

    /**
     * Entity to use
     *
     * @var string
     */
    const ENTITY_CLASS = 'AppBundle:User';

    /**
     * Entity manager
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
     * Find all users
     *
     * @param string $sortField
     * @param string $sortOrder
     *
     * @return array
     */
    public function findAll($sortField = 'createdAt', $sortOrder = 'DESC')
    {
        return $this->getQueryBuilder()
            ->orderBy(self::ENTITY_ALIAS . '.' . $sortField, $sortOrder)
            ->getQuery()
            ->getResult();
    }

    /**
     * Create an user
     *
     * @param User $user
     */
    public function create(User $user)
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }

    /**
     * Update an user
     *
     * @param User $user
     */
    public function update(User $user)
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }

    /**
     * Delete an user
     *
     * @param User $user
     */
    public function delete(User $user)
    {
        $this->objectManager->remove($user);
        $this->objectManager->flush();
    }

    /**
     * Return a new query builder
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
