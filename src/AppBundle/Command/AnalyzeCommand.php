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

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AnalyzeCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName('packy:analyze')
            ->setDescription('Analyze all projects');
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
        $projects = $projectRepository->findAll();

        foreach ($projects as $project) {
            $analyzer = $this->getContainer()->get('packy.analyzer.generic_analyzer');
            $dependencies = $analyzer->analyzeForManager($project, 'composer');
            $project->setDependencies($dependencies);

            $projectRepository->update($project);

            $output->writeln("<info>Project " . $project->getName() . " updated!</info>");
        }
    }
}
