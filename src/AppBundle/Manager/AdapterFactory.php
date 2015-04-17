<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Project;
use AppBundle\Service\SettingsService;

class AdapterFactory
{
    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * Constructor
     *
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Create for manager
     *
     * @param Project $project
     *
     * @return AdapterInterface
     */
    public function createAdapter(Project $project)
    {
        if (strpos($project->getRepositoryUrl(), 'github') !== false) {
            return new GithubAdapter();
        } elseif (strpos($project->getRepositoryUrl(), 'gitlab') !== false) {
            return new GitlabAdapter($this->settingsService);
        } elseif (strpos($project->getRepositoryUrl(), 'bitbucket') !== false) {
            return new BitbucketAdapter();
        }

        throw new \InvalidArgumentException('Unknown adapter for: '.$project->getRepositoryUrl());
    }
}
