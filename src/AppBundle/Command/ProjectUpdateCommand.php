<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command;

use AppBundle\Entity\Dependency;
use AppBundle\Entity\Package;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectUpdateCommand extends ContainerAwareCommand
{
    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName('packy:project:update')
            ->setDescription('Update the dependencies of projects');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectRepository = $this->getContainer()->get('packy.repository.project');
        $packageRepository = $this->getContainer()->get('packy.repository.package');
        $repositoryManagers = $this->getContainer()->get('packy.repository_managers');
        $dependencyManagers = $this->getContainer()->get('packy.dependency_managers');
        $packageManagers = $this->getContainer()->get('packy.package_managers');
        $versionFormatter = $this->getContainer()->get('packy.service.version_formatter');

        $projects = $projectRepository->findAll();

        foreach ($projects as $project) {
            $repository = $repositoryManagers->get($project->getRepositoryType());

            foreach ($dependencyManagers->getAll() as $dependencyManager) {
                $dependencies = $dependencyManager->fetchDependencies($repository, $project);

                foreach ($dependencies as $name => $version) {
                    $package = $packageRepository->findOne($name, $dependencyManager->getName());
                    if (null === $package) {
                        $package = new Package();
                        $package->setName($name);
                        $package->setManager($dependencyManager->getName());
                        $packageRepository->create($package);
                    }

                    $packageManager = $packageManagers->get($package->getManager());

                    $package = $packageManager->analyzePackage($package);
                    $packageRepository->update($package);

                    $dependency = new Dependency();
                    $dependency->setPackage($package);
                    $dependency->setRawVersion($version);
                    $dependency->setCurrentVersion($versionFormatter->normalizeVersion($version));
                    $project->addDependency($dependency);
                }
            }

            $projectRepository->update($project);

            $output->writeln('<info>Project ' . $project->getName() . ' updated!</info>');
        }
    }
}
