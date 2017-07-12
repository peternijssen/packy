<?php declare(strict_types=1);

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\RepositoryManager;

class RepositoryManagers
{
    /**
     * @var array
     */
    private $repositoryManagers;

    /**
     * RepositoryManagers constructor.
     */
    public function __construct()
    {
        $this->repositoryManagers = [];
    }

    /**
     * @param RepositoryManager $manager
     * @param string            $alias
     */
    public function add(RepositoryManager $manager, string $alias)
    {
        $this->repositoryManagers[$alias] = $manager;
    }

    /**
     * @param string $alias
     *
     * @return RepositoryManager
     */
    public function get(string $alias): RepositoryManager
    {
        return $this->repositoryManagers[$alias];
    }
}
