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

use AppBundle\Form\Type\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /**
     * Change password user
     *
     * @param Request $request A Request instance
     *
     * @return Response A Response instance
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        $profileForm = $this->createForm(ChangePasswordType::class, $user);

        if ($request->isMethod('POST')) {
            $profileForm->handleRequest($request);
            if ($profileForm->isValid()) {

                if (0 !== strlen($user->getPlainPassword())) {
                    $encoder = $this->container->get('security.password_encoder');
                    $user->setPassword($encoder->encodePassword($user, $user->getPlainPassword()));
                    $user->eraseCredentials();
                }

                $userRepository = $this->get('packy.repository.user');
                $userRepository->update($user);

                return $this->redirect($this->generateUrl('packy_project_overview'));
            }
        }

        return $this->render(
            "AppBundle:Profile:change_password.html.twig",
            [
                'user' => $user,
                'profileForm' => $profileForm->createView(),
            ]
        );
    }
}
