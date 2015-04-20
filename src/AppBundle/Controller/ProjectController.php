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

use AppBundle\Entity\Project;
use AppBundle\Form\Type\ProjectFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProjectController extends Controller
{

    /**
     * Project overview page
     *
     * @return Response A Response instance
     */
    public function overviewAction()
    {
        $projectRepository = $this->get('packy.repository.project');
        $projects = $projectRepository->findAll();

        return $this->render(
            'AppBundle:Project:overview.html.twig',
            array(
                'projects' => $projects,
            )
        );
    }

    /**
     * Add project
     *
     * @param Request $request A Request instance
     *
     * @return Response A Response instance
     */
    public function addAction(Request $request)
    {
        $project = new Project();
        $projectForm = $this->createForm(new ProjectFormType(), $project);

        if ($request->isMethod('POST')) {
            $projectForm->handleRequest($request);
            if ($projectForm->isValid()) {
                $projectManager = $this->get('packy.repository.project');
                $projectManager->create($project);

                return $this->redirect($this->generateUrl('packy_project_overview'));
            }
        }

        return $this->render(
            "AppBundle:Project:form.html.twig",
            array(
                'project' => $project,
                'projectForm' => $projectForm->createView(),
            )
        );
    }

    /**
     * @ParamConverter("project", class="AppBundle:Project", options={"id" = "projectId"})
     *
     * Analyze project
     *
     * @param Project $project
     *
     * @return Response A Response instance
     */
    public function analyzeAction(Project $project)
    {
        $dependencyRepository = $this->get('packy.repository.dependency');

        return $this->render(
            "AppBundle:Project:analyze.html.twig",
            array(
                'project' => $project,
                'composer' => $dependencyRepository->findAll($project, 'composer'),
                'npm' => $dependencyRepository->findAll($project, 'npm'),
                'pip' => $dependencyRepository->findAll($project, 'pip'),
            )
        );
    }

    /**
     * @ParamConverter("project", class="AppBundle:Project", options={"id" = "projectId"})
     *
     * Edit project
     *
     * @param Request $request A Request instance
     * @param Project $project
     *
     * @return Response A Response instance
     */
    public function editAction(Request $request, Project $project)
    {
        $projectForm = $this->createForm(new ProjectFormType(), $project);

        if ($request->isMethod('POST')) {
            $projectForm->handleRequest($request);
            if ($projectForm->isValid()) {
                $projectRepository = $this->get('packy.repository.project');
                $projectRepository->update($project);

                return $this->redirect($this->generateUrl('packy_project_overview'));
            }
        }

        return $this->render(
            "AppBundle:Project:form.html.twig",
            array(
                'project' => $project,
                'projectForm' => $projectForm->createView(),
            )
        );
    }

    /**
     * @ParamConverter("project", class="AppBundle:Project", options={"id" = "projectId"})
     *
     * Delete project
     *
     * @param Project $project
     *
     * @return RedirectResponse A Response instance
     */
    public function deleteAction(Project $project)
    {
        $projectRepository = $this->get('packy.repository.project');
        $projectRepository->delete($project);

        return $this->redirect($this->generateUrl('packy_project_overview'));
    }
}
