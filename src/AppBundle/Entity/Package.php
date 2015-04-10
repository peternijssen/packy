<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class Package
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $manager;

    /**
     * @var string
     */
    private $latestVersion;

    /**
     * @var \DateTime
     */
    private $lastChecktAt;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Collection
     */
    private $dependencies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dependencies = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Package
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set manager
     *
     * @param string $manager
     * @return Package
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return string
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set latestVersion
     *
     * @param string $latestVersion
     * @return Package
     */
    public function setLatestVersion($latestVersion)
    {
        $this->latestVersion = $latestVersion;

        return $this;
    }

    /**
     * Get latestVersion
     *
     * @return string
     */
    public function getLatestVersion()
    {
        return $this->latestVersion;
    }

    /**
     * Set lastChecktAt
     *
     * @param \DateTime $lastChecktAt
     *
     * @return Package
     */
    public function setLastChecktAt(\DateTime $lastChecktAt)
    {
        $this->lastChecktAt = $lastChecktAt;

        return $this;
    }

    /**
     * Get lastChecktAt
     *
     * @return \DateTime
     */
    public function getLastChecktAt()
    {
        return $this->lastChecktAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Package
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Package
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add dependencies
     *
     * @param Dependency $dependencies
     * @return Package
     */
    public function addDependency(Dependency $dependencies)
    {
        $this->dependencies[] = $dependencies;

        return $this;
    }

    /**
     * Remove dependencies
     *
     * @param Dependency $dependencies
     */
    public function removeDependency(Dependency $dependencies)
    {
        $this->dependencies->removeElement($dependencies);
    }

    /**
     * Get dependencies
     *
     * @return Collection
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }
}
