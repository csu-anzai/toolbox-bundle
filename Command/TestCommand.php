<?php

namespace Atournayre\ToolboxBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'test';

    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $output->writeln((new \DateTime('yesterday'))->format('d/m/Y H:i'));
//        $output->writeln((new \DateTime('midnight'))->format('d/m/Y H:i'));
//        $output->writeln((new \DateTime('today'))->format('d/m/Y H:i'));
//        $output->writeln((new \DateTime('now'))->format('d/m/Y H:i'));
//        $output->writeln((new \DateTime('noon'))->format('d/m/Y H:i'));
//        $output->writeln((new \DateTime('tomorrow'))->format('d/m/Y H:i'));
//        $output->writeln((new \DateTime('back of 1am'))->format('d/m/Y H:i'));
//        $output->writeln((new \DateTime('back of 13'))->format('d/m/Y H:i'));
//        $output->writeln((new \DateTime('first day of January 2018'))->format('d/m/Y H:i'));
//        $output->writeln((new \DateTime('last day of next month'))->format('d/m/Y H:i'));
        $output->writeln((new \DateTime('first saturday of august 2019'))->format('d/m/Y H:i'));
        $output->writeln((new \DateTime('second saturday of august 2019'))->format('d/m/Y H:i'));
        $output->writeln((new \DateTime('third saturday of august 2019'))->format('d/m/Y H:i'));
        $output->writeln((new \DateTime(sprintf('first friday of %s %s', date('M'), date('Y'))))->format('d/m/Y H:i'));
        $output->writeln((new \DateTime(sprintf('third friday of %s %s', date('M'), date('Y'))))->format('d/m/Y H:i'));

    }

}
