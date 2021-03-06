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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * Project overview page.
     *
     * @return Response A Response instance
     */
    public function overviewAction()
    {
        $projectRepository = $this->get('packy.repository.project');
        $projects = $projectRepository->findAll();

        return $this->render(
            'AppBundle:Project:overview.html.twig',
            [
                'projects' => $projects,
            ]
        );
    }

    /**
     * Add project.
     *
     * @param Request $request A Request instance
     *
     * @return Response A Response instance
     */
    public function addAction(Request $request)
    {
        $project = new Project();
        $projectForm = $this->createForm(ProjectFormType::class, $project);

        if ($request->isMethod('POST')) {
            $projectForm->handleRequest($request);
            if ($projectForm->isValid()) {
                $projectManager = $this->get('packy.repository.project');
                $projectManager->create($project);

                return $this->redirect($this->generateUrl('packy_project_overview'));
            }
        }

        return $this->render(
            'AppBundle:Project:form.html.twig',
            [
                'project' => $project,
                'projectForm' => $projectForm->createView(),
            ]
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

        $dependencyManagers = $this->get('packy.dependency_managers');
        $dependencyManagers = $dependencyManagers->getAll();

        //@TODO: Refactor
        $vendors = [];
        foreach ($dependencyManagers as $manager) {
            $name = $manager->getName();
            $dependencies = $dependencyRepository->findAllByManager($project, $name);
            if (!empty($dependencies)) {
                $vendors[$name] = $dependencies;
            }
        }

        //@TODO: BIG Refactor
        $stats = [
            'outdated' => [],
            'unstable' => [],
            'stable' => [],
        ];

        foreach ($vendors as $name => $dependencies) {
            foreach ($stats as &$stat) {
                $stat[$name] = 0;
            }

            unset($stat);

            foreach ($stats as $type => $stat) {
                foreach ($dependencies as $dependency) {
                    if ($dependency->getStatus() == $type) {
                        $stats[$type][$name] += 1;
                    }
                }
            }
        }

        return $this->render(
            'AppBundle:Project:analyze.html.twig',
            [
                'project' => $project,
                'vendors' => $vendors,
                'stats' => $stats,
            ]
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
        $projectForm = $this->createForm(ProjectFormType::class, $project);

        if ($request->isMethod('POST')) {
            $projectForm->handleRequest($request);
            if ($projectForm->isValid()) {
                $projectRepository = $this->get('packy.repository.project');
                $projectRepository->update($project);

                return $this->redirect($this->generateUrl('packy_project_overview'));
            }
        }

        return $this->render(
            'AppBundle:Project:form.html.twig',
            [
                'project' => $project,
                'projectForm' => $projectForm->createView(),
            ]
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
