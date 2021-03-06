<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class Builder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var AuthorizationChecker
     */
    private $security;

    /**
     * @param FactoryInterface     $factory
     * @param AuthorizationChecker $security
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, AuthorizationChecker $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    /**
     * Create the side menu.
     *
     * @return ItemInterface
     */
    public function createSideMenu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'sidebar-menu');

        $menu->addChild(
            'Projects',
            [
                'route' => 'packy_project_overview',
                'extras' => [
                    'icon' => 'fa-tasks fa-fw',
                ],
            ]
        );

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $menu->addChild(
                'Users',
                [
                    'route' => 'packy_user_overview',
                    'extras' => [
                        'icon' => 'fa-users fa-fw',
                    ],
                ]
            );
        }

        return $menu;
    }
}
