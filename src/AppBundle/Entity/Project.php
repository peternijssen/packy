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

class Project
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
    private $description;

    /**
     * @var string
     */
    private $repositoryUrl;

    /**
     * @var string
     */
    private $repositoryType;

    /**
     * @var string
     */
    private $vendorName;

    /**
     * @var string
     */
    private $packageName;

    /**
     * @var string
     */
    private $branch;

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
     * Set description.
     *
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set repositoryUrl.
     *
     * @param string $repositoryUrl
     */
    public function setRepositoryUrl(string $repositoryUrl)
    {
        $this->repositoryUrl = $repositoryUrl;
    }

    /**
     * Get repositoryUrl.
     *
     * @return string
     */
    public function getRepositoryUrl(): string
    {
        return $this->repositoryUrl;
    }

    /**
     * Add dependencies.
     *
     * @TODO: Refactor
     *
     * @param Dependency $dependency
     */
    public function addDependency(Dependency $dependency)
    {
        $dependency->setProject($this);

        foreach ($this->dependencies as $k => $dep) {
            if ($dep->getPackage()->getName() == $dependency->getPackage()->getName()) {
                $dep->setCurrentVersion($dependency->getCurrentVersion());
                $dep->setRawVersion($dependency->getRawVersion());
                $dep->setRawVersion($dependency->getRawVersion());

                return $this;
            }
        }

        $this->dependencies[] = $dependency;
    }

    /**
     * Remove dependencies.
     *
     * @param Dependency $dependency
     */
    public function removeDependency(Dependency $dependency)
    {
        $this->dependencies->removeElement($dependency);
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

    /**
     * Set repositoryType.
     *
     * @param string $repositoryType
     */
    public function setRepositoryType(string $repositoryType)
    {
        $this->repositoryType = $repositoryType;
    }

    /**
     * Get repositoryType.
     *
     * @return string
     */
    public function getRepositoryType(): string
    {
        return $this->repositoryType;
    }

    /**
     * Set vendorName.
     *
     * @param string $vendorName
     */
    public function setVendorName($vendorName)
    {
        $this->vendorName = $vendorName;
    }

    /**
     * Get vendorName.
     *
     * @return string
     */
    public function getVendorName(): string
    {
        return $this->vendorName;
    }

    /**
     * Set packageName.
     *
     * @param string $packageName
     */
    public function setPackageName(string $packageName)
    {
        $this->packageName = $packageName;
    }

    /**
     * Get packageName.
     *
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->packageName;
    }

    /**
     * Set branch.
     *
     * @param string $branch
     */
    public function setBranch(string $branch)
    {
        $this->branch = $branch;
    }

    /**
     * Get branch.
     *
     * @return string
     */
    public function getBranch(): string
    {
        return $this->branch;
    }

    /**
     * Get the total stats.
     *
     * @todo: Refactor into a service
     *
     * @return array
     */
    public function getTotalStats(): array
    {
        $stats = ['unstable' => 0, 'stable' => 0, 'outdated' => 0];

        foreach ($this->getDependencies() as $dependency) {
            $stats[$dependency->getStatus()] += 1;
        }

        return $stats;
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
     *
     * @return Project
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
     * Set deletedAt.
     *
     * @param \DateTimeInterface $deletedAt
     */
    public function setDeletedAt(\DateTimeInterface $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * Get deletedAt.
     *
     * @return \DateTimeInterface|null
     */
    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }
}
