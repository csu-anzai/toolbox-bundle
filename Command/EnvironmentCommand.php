<?php

namespace Atournayre\ToolboxBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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
            ->setDescription('Setup environment.')
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
            exit;
        }

        $this->runCommands($env, $io);
        $io->success(sprintf('Environment "%s" is ready. Have fun!', $env));
    }

    /**
     * @param string       $env
     * @param SymfonyStyle $io
     */
    private function runCommands(string $env, SymfonyStyle $io): void
    {
        foreach ($this->environmentCommands[$env] as $command) {
            $this->runCommand($command, $io);
        }
    }

    /**
     * @param string       $command
     * @param SymfonyStyle $io
     */
    private function runCommand(string $command, SymfonyStyle $io): void
    {
        $io->section($command);
        $process = Process::fromShellCommandline($command);
        $process->start();
        $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);
        foreach ($iterator as $data) {
            $io->writeln(trim($data));
        }
    }
}
