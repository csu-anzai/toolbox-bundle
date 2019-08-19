<?php

namespace Atournayre\ToolboxBundle\EventListener;

use Atournayre\ToolboxBundle\Entity\Parameter;
use Atournayre\ToolboxBundle\Repository\ParameterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MaintenanceListener implements EventSubscriberInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var array
     */
    private $maintenanceParameters;

    /**
     * MaintenanceListener constructor.
     *
     * @param Environment            $twig
     * @param EntityManagerInterface $entityManager
     * @param array                  $maintenanceParameters
     */
    public function __construct(Environment $twig, EntityManagerInterface $entityManager, array $maintenanceParameters)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->maintenanceParameters = $maintenanceParameters;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest',
                -128,
            ],
        ];
    }

    /**
     * @param GetResponseEvent $event
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        /** @var ParameterRepository $parameterRepository */
        $parameterRepository = $this->entityManager->getRepository(Parameter::class);
        $parameter = $parameterRepository->findOneByCode(Parameter::CODE_MAINTENANCE);

        if (is_null($parameter)) {
            return;
        }

        if (!is_null($parameter) && $parameter->getBooleanValue()) {
            $custom = $this->maintenanceParameters['custom'];
            $system = $this->maintenanceParameters['system'];
            $render = null !== $custom['template']
                ? $this->twig->render($custom['template'])
                : $this->twig->render('maintenance/index.html.twig', [
                    'system_base' => $system['base'],
                    'system_title' => $system['title'],
                    'system_content' => $system['content'],
                ]);

            $response = new Response($render, Response::HTTP_OK, ['content-type' => 'text/html']);
            $event->setResponse(new Response($response->getContent()));
            $event->stopPropagation();
        }
    }
}
