<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Form\Type\SettingsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends Controller
{

    /**
     * Gitlab settings ation
     *
     * @return Response A Response instance
     */
    public function gitlabAction(Request $request)
    {
        $availableSettings = array('gitlab_url', 'gitlab_token');
        $settingsRepository = $this->get('packy.repository.setting');

        $settings = $settingsRepository->getSettingsByName($availableSettings);

        $settingsForm = $this->createForm(new SettingsFormType($settings));

        if ($request->isMethod('POST')) {
            $settingsForm->handleRequest($request);
            if ($settingsForm->isValid()) {
                $settingsRepository->updateBatch($settings);

                return $this->redirect($this->generateUrl('packy_project_overview'));
            }
        }

        return $this->render(
            "AppBundle:Settings:gitlab.html.twig",
            array(
                'settingsForm' => $settingsForm->createView(),
            )
        );
    }
}
