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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName('packy:install')
            ->setDescription('Install packy');
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
        $command = $this->getApplication()->find('doctrine:database:create');
        $arguments = [
            'command' => 'doctrine:database:create',
            '--if-not-exists' => true,
            '--quiet' => true,
        ];
        $input = new ArrayInput($arguments);
        $input->setInteractive(false);
        $command->run($input, $output);

        $command = $this->getApplication()->find('doctrine:migrations:migrate');
        $arguments = [
            'command' => 'doctrine:migrations:migrate',
            '--quiet' => true,
        ];
        $input = new ArrayInput($arguments);
        $input->setInteractive(false);
        $command->run($input, $output);

        $userCommand = $this->getApplication()->find('fos:user:create');
        $arguments = [
            'command' => 'fos:user:create',
            '--super-admin' => true,
        ];
        $input = new ArrayInput($arguments);
        $userCommand->run($input, $output);
    }
}
