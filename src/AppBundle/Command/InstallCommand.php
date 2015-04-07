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
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends ContainerAwareCommand
{
    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName('packy:install')
            ->setDescription('Install packy');
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
        $command = $this->getApplication()->find('doctrine:schema:update');
        $arguments = array(
            'command' => 'doctrine:schema:update',
            '--force' => true
        );
        $input = new ArrayInput($arguments);
        $command->run($input, $output);

        $command = $this->getApplication()->find('fos:user:create');
        $arguments = array(
            'command' => 'fos:user:create',
            '--super-admin' => true
        );
        $input = new ArrayInput($arguments);
        $command->run($input, $output);
    }
}
