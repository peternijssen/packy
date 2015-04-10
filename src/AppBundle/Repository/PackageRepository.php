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

use AppBundle\Entity\Package;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;

class PackageRepository
{

    /**
     * Entity alias
     *
     * @var string
     */
    const ENTITY_ALIAS = 'pa';

    /**
     * Entity to use
     *
     * @var string
     */
    const ENTITY_CLASS = 'AppBundle:Package';

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
     * Find all packages
     *
     * @param string $sortField
     * @param string $sortOrder
     *
     * @return array
     */
    public function findAll($sortField = 'createdAt', $sortOrder = 'DESC')
    {
        return $this->getQueryBuilder()
            ->orderBy(self::ENTITY_ALIAS.'.'.$sortField, $sortOrder)
            ->getQuery()
            ->getResult();
    }

    /**
     * Return one package
     *
     * @param string $name
     * @param string $manager
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOne($name, $manager)
    {
        return $this->getQueryBuilder()
            ->where(self::ENTITY_ALIAS.'.name = :name')
            ->andWhere(self::ENTITY_ALIAS.'.manager = :manager')
            ->setParameter(':name', $name)
            ->setParameter(':manager', $manager)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Create a package
     *
     * @param Package $package
     */
    public function create(Package $package)
    {
        $this->objectManager->persist($package);
        $this->objectManager->flush();
    }

    /**
     * Update a package
     *
     * @param Package $package
     */
    public function update(Package $package)
    {
        $this->objectManager->persist($package);
        $this->objectManager->flush();
    }

    /**
     * Delete a package
     *
     * @param Package $package
     */
    public function delete(Package $package)
    {
        $this->objectManager->remove($package);
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
