<?php

namespace Atournayre\ToolboxBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenKeyCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('encrypt:genkey')
            ->setDescription('Generate a 256-bit encryption key.')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Generated Key');
        $io->success(base64_encode(openssl_random_pseudo_bytes(32)));
        return;
    }
}