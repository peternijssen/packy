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

use Composer\Semver\Comparator;

class Dependency
{
    /**
     * @var int
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
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set rawVersion.
     *
     * @param string $rawVersion
     */
    public function setRawVersion(string $rawVersion)
    {
        $this->rawVersion = $rawVersion;
    }

    /**
     * Get rawVersion.
     *
     * @return string
     */
    public function getRawVersion(): string
    {
        return $this->rawVersion;
    }

    /**
     * Set currentVersion.
     *
     * @param string $currentVersion
     */
    public function setCurrentVersion(string $currentVersion)
    {
        $this->currentVersion = $currentVersion;
    }

    /**
     * Get currentVersion.
     *
     * @return string
     */
    public function getCurrentVersion(): string
    {
        return $this->currentVersion;
    }

    /**
     * Set project.
     *
     * @param Project $project
     */
    public function setProject(Project $project = null)
    {
        $this->project = $project;
    }

    /**
     * Get project.
     *
     * @return Project
     */
    public function getProject(): ?Project
    {
        return $this->project;
    }

    /**
     * Set package.
     *
     * @param Package $package
     */
    public function setPackage(Package $package = null)
    {
        $this->package = $package;
    }

    /**
     * Get package.
     *
     * @return Package
     */
    public function getPackage(): ?Package
    {
        return $this->package;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus(): string
    {
        if (preg_match('/[a-zA-Z]+$/', $this->getRawVersion())) {
            return 'unstable';
        }

        if (Comparator::greaterThanOrEqualTo($this->getCurrentVersion(), $this->package->getLatestVersion())) {
            return 'stable';
        }

        return 'outdated';
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
}
