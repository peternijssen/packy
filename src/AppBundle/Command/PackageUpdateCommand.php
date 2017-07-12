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

class PackageUpdateCommand extends ContainerAwareCommand
{
    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName('packy:package:update')
            ->setDescription('Update the version of the package');
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
        $packageRepository = $this->getContainer()->get('packy.repository.package');
        $packageManagers = $this->getContainer()->get('packy.package_managers');
        $packages = $packageRepository->findAll();

        foreach ($packages as $package) {
            $packageManager = $packageManagers->get($package->getManager());
            $package = $packageManager->analyzePackage($package);
            $packageRepository->update($package);
            $output->writeln('<info>Package ' . $package->getName() . ' updated!</info>');
        }
    }
}
