<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Repository\SettingRepository;

class SettingsService
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * Constructor
     *
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Get value for config setting
     *
     * @param mixed $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function getValue($name, $default = null)
    {
        $setting = $this->settingRepository->findByName($name);
        if (is_null($setting)) {
            return $default;
        }

        return $setting->getValue();
    }
}
