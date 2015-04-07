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
use AppBundle\Form\Type\ProjectType;
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
                'projects' => $projects
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
        $projectForm = $this->createForm(new ProjectType(), $project);

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
                'projectForm' => $projectForm->createView()
            )
        );
    }

    /**
     * @ParamConverter("project", class="AppBundle:Project", options={"id" = "projectId"})
     *
     * Analyze project
     *
     * @param Request $request A Request instance
     * @param Project $project
     *
     * @return Response A Response instance
     */
    public function analyzeAction(Request $request, Project $project)
    {
        //@TODO: Should be done by a Command
        $analyzer = $this->get('packy.analyzer.generic_analyzer');
        $dependencies = $analyzer->analyzeForManager($project, 'composer');
        $project->setDependencies($dependencies);

        $projectRepository = $this->get('packy.repository.project');
        $projectRepository->update($project);

        return $this->render(
            "AppBundle:Project:analyze.html.twig",
            array(
                'project' => $project
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
        $projectForm = $this->createForm(new ProjectType(), $project);

        if ($request->isMethod('POST')) {
            $projectForm->handleRequest($request);
            if ($projectForm->isValid()) {
                $projectManager = $this->get('packy.repository.project');
                $projectManager->update($project);

                return $this->redirect($this->generateUrl('packy_project_overview'));
            }
        }

        return $this->render(
            "AppBundle:Project:form.html.twig",
            array(
                'projectForm' => $projectForm->createView()
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
        $projectManager = $this->get('packy.repository.project');
        $projectManager->delete($project);

        return $this->redirect($this->generateUrl('packy_project_overview'));
    }
}
