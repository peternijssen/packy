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
    private $rawVersion;

    /**
     * @var string
     */
    private $currentVersion;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Project
     */
    private $project;

    /**
     * @var Package
     */
    private $package;

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
     * Set rawVersion
     *
     * @param string $rawVersion
     *
     * @return Dependency
     */
    public function setRawVersion($rawVersion)
    {
        $this->rawVersion = $rawVersion;

        return $this;
    }

    /**
     * Get rawVersion
     *
     * @return string
     */
    public function getRawVersion()
    {
        return $this->rawVersion;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Dependency
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
     *
     * @return Dependency
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
     * @param Package $package
     *
     * @return Dependency
     */
    public function setPackage(Package $package = null)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get package
     *
     * @return Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        if (preg_match('/[a-zA-Z]+$/', $this->getRawVersion())) {
            return "unstable";
        }

        if (version_compare($this->package->getLatestVersion(), $this->getCurrentVersion()) < 0) {
            return "stable";
        }

        return "outdated";
    }
}
