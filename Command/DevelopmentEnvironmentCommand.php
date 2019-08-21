<?php

namespace Atournayre\ToolboxBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DevelopmentEnvironmentCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'init:dev';

    protected function configure(): void
    {
        $this
            ->setDescription('Setup development environment.')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);



        $io->success('Development environment is ready.');
    }
}
