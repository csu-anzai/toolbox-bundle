<?php

namespace Atournayre\ToolboxBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestConfigCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'test:config';

    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $s = $this->getContainer()->get('atournayre_toolbox.date.format');

        $output->writeln($s->simpleDate(new \DateTime()));

        $output->writeln($s->valeurVideOuFormat(null, 'y'));
    }

}
