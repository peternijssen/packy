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
use AppBundle\Fetcher\ComposerFetcher;
use AppBundle\Fetcher\NpmFetcher;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectUpdateCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName('packy:project:update')
            ->setDescription('Update the dependencies of projects');
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectRepository = $this->getContainer()->get('packy.repository.project');
        $packageRepository = $this->getContainer()->get('packy.repository.package');
        $analyzer = $this->getContainer()->get('packy.analyzer.generic_analyzer');
        $versionFormatter = $this->getContainer()->get('packy.service.version_formatter');

        $projects = $projectRepository->findAll();

        foreach ($projects as $project) {
            // Composer fetcher
            $composerFetcher = $this->getContainer()->get('packy.fetcher.composer_fetcher');
            $dependencies = $composerFetcher->fetchDependencies($project);

            foreach ($dependencies as $name => $version) {
                $package = $packageRepository->findOne($name, 'composer');
                if (is_null($package)) {
                    $package = new Package();
                    $package->setName($name);
                    $package->setManager('composer');
                    $packageRepository->create($package);
                }
                
                $package = $analyzer->analyzePackage($package, $package->getManager());
                $packageRepository->update($package);

                $dependency = new Dependency();
                $dependency->setPackage($package);
                $dependency->setRawVersion($version);
                $dependency->setCurrentVersion($versionFormatter->normalizeVersion($version));
                $project->addDependency($dependency);
            }

            // Npm fetcher
            $npmFetcher = $this->getContainer()->get('packy.fetcher.npm_fetcher');
            $dependencies = $npmFetcher->fetchDependencies($project);

            foreach ($dependencies as $name => $version) {
                $package = $packageRepository->findOne($name, 'npm');
                if (is_null($package)) {
                    $package = new Package();
                    $package->setName($name);
                    $package->setManager('npm');
                    $packageRepository->create($package);
                }

                $package = $analyzer->analyzePackage($package, $package->getManager());
                $packageRepository->update($package);

                $dependency = new Dependency();
                $dependency->setPackage($package);
                $dependency->setRawVersion($version);
                $dependency->setCurrentVersion($versionFormatter->normalizeVersion($version));
                $project->addDependency($dependency);
            }

            $projectRepository->update($project);

            $output->writeln("<info>Project ".$project->getName()." updated!</info>");
        }
    }
}
