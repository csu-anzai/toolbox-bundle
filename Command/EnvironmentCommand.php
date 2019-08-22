<?php

namespace Atournayre\ToolboxBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class EnvironmentCommand extends Command
{
    /**
     * @var array
     */
    private $commands;

    /**
     * @var string
     */
    protected static $defaultName = 'init';

    /**
     * DevelopmentEnvironmentCommand constructor.
     *
     * @param array $commands
     */
    public function __construct(array $commands)
    {
        parent::__construct(self::$defaultName);
        $this->commands = $commands;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Setup development environment.')
            ->addOption('env', 'env', InputOption::VALUE_REQUIRED, 'Environment as defined in your config file.', 'dev')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

//        print_r($this->commands);

        $io->success('Development environment is ready.');
    }
}
