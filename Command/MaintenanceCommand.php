<?php

namespace Atournayre\ToolboxBundle\Command;

use Atournayre\ToolboxBundle\Entity\Parameter;
use Atournayre\ToolboxBundle\Repository\ParameterRepository;
use Atournayre\ToolboxBundle\Service\Maintenance\MaintenanceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class MaintenanceCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'maintenance';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var MaintenanceService
     */
    private $maintenanceService;

    /**
     * MaintenanceCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param MaintenanceService     $maintenanceService
     */
    public function __construct(EntityManagerInterface $entityManager, MaintenanceService $maintenanceService)
    {
        parent::__construct(self::$defaultName);
        $this->entityManager = $entityManager;
        $this->maintenanceService = $maintenanceService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Setup maintenance for the application.')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        /** @var ParameterRepository $parameterRepository */
        $parameterRepository = $this->entityManager->getRepository(Parameter::class);
        $parameter = $parameterRepository->findOneByCode(Parameter::CODE_MAINTENANCE);

        if (is_null($parameter)) {
            $parameter = $this->maintenanceService->create();
            $this->entityManager->persist($parameter);
            $this->entityManager->flush();
        }

        $io->write($this->maintenanceService->systemState($parameter->getValeurBooleene()));

        $question = new ConfirmationQuestion(
            $this->question($parameter->getValeurBooleene()),
            true,
            '/^(y|o)/i'
        );

        $response = $io->askQuestion($question);

        if ($response) {
            $parameter = $this->maintenanceService->update($parameter);
            $this->entityManager->flush();
            $io->success($this->maintenanceService->systemState($parameter->getBooleanValue()));
        }

        if (!$response) {
            $io->success('No changes.');
        }
    }

    /**
     * @param bool $value
     *
     * @return string
     */
    private function question(bool $value): string
    {
        return $value
            ? 'Activate the application?'
            : 'Desactivate the application?';
    }
}
