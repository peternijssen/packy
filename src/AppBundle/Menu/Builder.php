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
use \Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{

    /**
     * Create the side menu
     *
     * @param FactoryInterface $factory Menu Factory
     *
     * @return ItemInterface
     */
    public function sideMenu(FactoryInterface $factory)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'sidebar-menu');

        $menu->addChild(
            'Projects',
            array(
                'route' => 'packy_project_overview',
                'extras' => array(
                    'icon' => 'fa-tasks fa-fw',
                ),
            )
        );

        $menu->addChild(
            'Users',
            array(
                'route' => 'packy_user_overview',
                'extras' => array(
                    'icon' => 'fa-users fa-fw',
                ),
            )
        );

        $settingsMenu = $menu->addChild(
            'Settings',
            array(
                'childrenAttributes' => array('class' => 'treeview-menu'),
                'route' => 'packy_settings_overview',
                'attributes' => array('class' => 'treeview'),
                'extras' => array(
                    'icon' => 'fa-cogs fa-fw',
                ),
            )
        );

        $this->settingsMenu($settingsMenu);

        return $menu;
    }

    /**
     * Settings sub menu
     *
     * @param ItemInterface $menu
     *
     * @return ItemInterface
     */
    protected function settingsMenu(ItemInterface $menu)
    {
        $menu->addChild(
            'Gitlab',
            array(
                'route' => 'packy_settings_gitlab_overview',
                'extras' => array(
                    'icon' => 'fa-git fa-fw',
                ),
            )
        );

        return $menu;
    }
}
