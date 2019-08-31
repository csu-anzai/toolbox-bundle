<?php

namespace Atournayre\ToolboxBundle\Command;

use Atournayre\ToolboxBundle\Installer\Address;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddressCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Address
     */
    private $addressInstaller;

    /**
     * @var string
     */
    protected static $defaultName = 'install:address';

    /**
     * AddressCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param Address                $addressInstaller
     */
    public function __construct(EntityManagerInterface $entityManager, Address $addressInstaller)
    {
        parent::__construct(self::$defaultName);
        $this->entityManager = $entityManager;
        $this->addressInstaller = $addressInstaller;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Install datas for address.')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws ConnectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        $this->executeSql($io, $this->addressInstaller->prepareSql());
    }

    /**
     * @param SymfonyStyle $io
     * @param string       $sql
     *
     * @throws ConnectionException
     */
    public function executeSql(SymfonyStyle $io, string $sql)
    {
        $connection = $this->entityManager->getConnection();
        $connection->beginTransaction();
        try {
            $connection->exec($sql);
            $connection->commit();
            $io->success('Address datas have been successfully installed!');
        } catch (Exception $exception) {
            $connection->rollBack();
            $io->error($exception);
        }
    }
}
