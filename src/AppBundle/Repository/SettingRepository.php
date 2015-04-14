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

use AppBundle\Entity\Setting;
use Doctrine\Common\Persistence\ObjectManager;

class SettingRepository
{
    /**
     * Entity alias
     *
     * @var string
     */
    const ENTITY_ALIAS = 's';

    /**
     * Entity to use
     *
     * @var string
     */
    const ENTITY_CLASS = 'AppBundle:Setting';

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
     * Find setting by name
     *
     * @param string $name settings name
     *
     * @return Setting
     */
    public function findByName($name)
    {
        return $this->getQueryBuilder()
            ->andWhere(self::ENTITY_ALIAS.'.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get settings by names
     *
     * @param array $names
     *
     * @return mixed
     */
    public function getSettingsByName(array $names)
    {
        return $this->getQueryBuilder()
            ->andWhere(self::ENTITY_ALIAS.'.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->getResult();
    }

    /**
     * Update a setting
     *
     * @param Setting $setting
     */
    public function update(Setting $setting)
    {
        $this->objectManager->persist($setting);
        $this->objectManager->flush();
    }

    /**
     * Update settings
     *
     * @param array $settings
     */
    public function updateBatch(array $settings)
    {
        foreach ($settings as $setting) {
            $this->objectManager->persist($setting);
        }

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
