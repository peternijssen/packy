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

use \Doctrine\Common\Collections\Collection;
use \Doctrine\Common\Collections\ArrayCollection;

class Project
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
    private $description;

    /**
     * @var string
     */
    private $repositoryUrl;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \DateTime
     */
    private $deletedAt;

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
     * @return Project
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
     * Set description
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set repositoryUrl
     *
     * @param string $repositoryUrl
     *
     * @return Project
     */
    public function setRepositoryUrl($repositoryUrl)
    {
        $this->repositoryUrl = $repositoryUrl;

        return $this;
    }

    /**
     * Get repositoryUrl
     *
     * @return string 
     */
    public function getRepositoryUrl()
    {
        return $this->repositoryUrl;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Project
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
     * @return Project
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

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Project
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Add dependencies
     *
     * @param Dependency $dependency
     *
     * @return Project
     */
    public function addDependency(Dependency $dependency)
    {
        $dependency->setProject($this);
        $this->dependencies[] = $dependency;

        return $this;
    }

    /**
     * Remove dependencies
     *
     * @param Dependency $dependency
     */
    public function removeDependency(Dependency $dependency)
    {
        $this->dependencies->removeElement($dependency);
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

    /**
     * Set dependencies
     *
     * @TODO: temp
     *
     * @param array $dependencies
     */
    public function setDependencies(array $dependencies)
    {
        foreach ($dependencies as $dependency) {
            $dependency->setProject($this);
        }

        $this->dependencies = $dependencies;
    }
}
