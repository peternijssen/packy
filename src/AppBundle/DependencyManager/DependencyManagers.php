<?php declare(strict_types=1);

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DependencyManager;

class DependencyManagers
{
    /**
     * @var array
     */
    private $dependencyManagers;

    /**
     * DependencyManagers constructor.
     */
    public function __construct()
    {
        $this->dependencyManagers = [];
    }

    /**
     * @param DependencyManager $manager
     * @param string            $alias
     */
    public function add(DependencyManager $manager, string $alias)
    {
        $this->dependencyManagers[$alias] = $manager;
    }

    /**
     * @return DependencyManager[]
     */
    public function getAll(): array
    {
        return $this->dependencyManagers;
    }
}
