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
    private $environmentCommands;

    /**
     * @var string
     */
    protected static $defaultName = 'init';

    /**
     * DevelopmentEnvironmentCommand constructor.
     *
     * @param array $environmentCommands
     */
    public function __construct(array $environmentCommands)
    {
        parent::__construct(self::$defaultName);
        $this->environmentCommands = $environmentCommands;
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
        $env = $input->getOption('env');

        if (!array_key_exists($env, $this->environmentCommands)) {
            $io->warning('Missing configuration of this env in your config.yml!');
        }

        $commands = $this->environmentCommands[$env];

        foreach ($commands as $command) {
            print_r($command);
        }


        print_r($this->environmentCommands);

        $io->success('Environment is ready. Have fun!');
    }
}
