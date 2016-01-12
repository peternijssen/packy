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

use AppBundle\Entity\User;
use AppBundle\Form\Type\ChangePasswordType;
use AppBundle\Form\Type\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends Controller
{

    /**
     * User overview page
     *
     * @return Response A Response instance
     */
    public function overviewAction()
    {
        $userRepository = $this->get('packy.repository.user');
        $users = $userRepository->findAll();

        return $this->render(
            'AppBundle:User:overview.html.twig',
            array(
                'users' => $users,
            )
        );
    }

    /**
     * Add user
     *
     * @param Request $request A Request instance
     *
     * @return Response A Response instance
     */
    public function addAction(Request $request)
    {
        $user = new User();
        $userForm = $this->createForm(UserFormType::class, $user);

        if ($request->isMethod('POST')) {
            $userForm->handleRequest($request);
            if ($userForm->isValid()) {
                $user->setEnabled(true);

                $userRepository = $this->get('packy.repository.user');
                $userRepository->create($user);

                return $this->redirect($this->generateUrl('packy_user_overview'));
            }
        }

        return $this->render(
            "AppBundle:User:form.html.twig",
            array(
                'user' => $user,
                'userForm' => $userForm->createView(),
            )
        );
    }

    /**
     * @ParamConverter("user", class="AppBundle:User", options={"id" = "userId"})
     *
     * Edit user
     *
     * @param Request $request A Request instance
     * @param User    $user
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request, User $user)
    {
        $userForm = $this->createForm(UserFormType::class, $user);

        if ($request->isMethod('POST')) {
            $userForm->handleRequest($request);
            if ($userForm->isValid()) {
                $userRepository = $this->get('packy.repository.user');
                $userRepository->update($user);

                return $this->redirect($this->generateUrl('packy_user_overview'));
            }
        }

        return $this->render(
            "AppBundle:User:form.html.twig",
            array(
                'user' => $user,
                'userForm' => $userForm->createView(),
            )
        );
    }

    /**
     * @ParamConverter("user", class="AppBundle:User", options={"id" = "userId"})
     *
     * Delete user
     *
     * @param User $user
     *
     * @return RedirectResponse A Response instance
     */
    public function deleteAction(User $user)
    {
        $userRepository = $this->get('packy.repository.user');
        $userRepository->delete($user);

        return $this->redirect($this->generateUrl('packy_user_overview'));
    }
}
