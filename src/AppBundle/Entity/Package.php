<?php declare(strict_types=1);

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Package
{
    /**
     * @var int
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
    private $lastCheckAt;

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
     * Constructor.
     */
    public function __construct()
    {
        $this->dependencies = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set manager.
     *
     * @param string $manager
     */
    public function setManager(string $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get manager.
     *
     * @return string
     */
    public function getManager(): string
    {
        return $this->manager;
    }

    /**
     * Set latestVersion.
     *
     * @param string $latestVersion
     */
    public function setLatestVersion(string $latestVersion)
    {
        $this->latestVersion = $latestVersion;
    }

    /**
     * Get latestVersion.
     *
     * @return string|null
     */
    public function getLatestVersion(): ?string
    {
        return $this->latestVersion;
    }

    /**
     * Set $lastCheckAt.
     *
     * @param \DateTimeInterface $lastCheckAt
     */
    public function setLastCheckAt(\DateTimeInterface $lastCheckAt)
    {
        $this->lastCheckAt = $lastCheckAt;
    }

    /**
     * Get lastCheckAt.
     *
     * @return \DateTimeInterface
     */
    public function getLastCheckAt(): \DateTimeInterface
    {
        return $this->lastCheckAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTimeInterface $updatedAt
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Add dependencies.
     *
     * @param Dependency $dependencies
     */
    public function addDependency(Dependency $dependencies)
    {
        $this->dependencies[] = $dependencies;
    }

    /**
     * Remove dependencies.
     *
     * @param Dependency $dependencies
     */
    public function removeDependency(Dependency $dependencies)
    {
        $this->dependencies->removeElement($dependencies);
    }

    /**
     * Get dependencies.
     *
     * @return Collection
     */
    public function getDependencies(): Collection
    {
        return $this->dependencies;
    }
}
