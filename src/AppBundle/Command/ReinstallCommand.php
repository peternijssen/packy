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
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ReinstallCommand extends Command
{
    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName('packy:reinstall')
            ->setDescription('Reinstall packy');
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
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            'Do you really want to reinstall packy? All data will be lost. (y/n) ',
            false
        );

        if (!$helper->ask($input, $output, $question)) {
            return;
        }

        $command = $this->getApplication()->find('doctrine:database:drop');
        $arguments = array(
            'command' => 'doctrine:database:drop',
            '--force' => true,
            '--quiet' => true,
        );

        $input = new ArrayInput($arguments);
        $input->setInteractive(false);
        $command->run($input, $output);

        $installCommand = $this->getApplication()->find('packy:install');
        $arguments = array(
            'command' => 'packy:install',
        );
        $installInput = new ArrayInput($arguments);
        $installCommand->run($installInput, $output);
    }
}
