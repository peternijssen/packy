<?php declare(strict_types=1);

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\PackageManager;

class PackageManagers
{
    /**
     * @var array
     */
    private $packageManagers;

    /**
     * RepositoryManagers constructor.
     */
    public function __construct()
    {
        $this->packageManagers = [];
    }

    /**
     * @param PackageManager $manager
     * @param string         $alias
     */
    public function add(PackageManager $manager, string $alias)
    {
        $this->packageManagers[$alias] = $manager;
    }

    /**
     * @param string $alias
     *
     * @return PackageManager
     */
    public function get(string $alias): PackageManager
    {
        return $this->packageManagers[$alias];
    }
}
