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

class Dependency
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $package;

    /**
     * @var string
     */
    private $manager;

    /**
     * @var string
     */
    private $currentVersion;

    /**
     * @var Project
     */
    private $project;

    /**
     * @var bool
     */
    private $isUpdate;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

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
     * Set currentVersion
     *
     * @param string $currentVersion
     *
     * @return Dependency
     */
    public function setCurrentVersion($currentVersion)
    {
        $this->currentVersion = $currentVersion;

        return $this;
    }

    /**
     * Get currentVersion
     *
     * @return string
     */
    public function getCurrentVersion()
    {
        return $this->currentVersion;
    }

    /**
     * Set project
     *
     * @param Project $project
     *
     * @return Dependency
     */
    public function setProject(Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set package
     *
     * @param string $package
     *
     * @return Dependency
     */
    public function setPackage($package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get package
     *
     * @return string
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set manager
     *
     * @param string $manager
     *
     * @return Dependency
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
     * Set isUpdate
     *
     * @param boolean $isUpdate
     *
     * @return Dependency
     */
    public function setIsUpdate($isUpdate)
    {
        $this->isUpdate = $isUpdate;

        return $this;
    }

    /**
     * Get isUpdate
     *
     * @return boolean
     */
    public function getIsUpdate()
    {
        return $this->isUpdate;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Dependency
     */
    public function setCreatedAt($createdAt)
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
     *
     * @return Dependency
     */
    public function setUpdatedAt($updatedAt)
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
}
