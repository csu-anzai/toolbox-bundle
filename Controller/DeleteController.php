<?php

namespace Atournayre\ToolboxBundle\Controller;

use Atournayre\ToolboxBundle\ConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteController extends AbstractController
{
    const ACTION_DELETE_JSON = __CLASS__ . '::deleteJson';

    /**
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param string                 $objectClass         The FQDN of the object to delete.
     * @param string                 $successMessage      The message if success.
     * @param string                 $confirmationMessage The confirmation message.
     * @param int                    $entityId            The id of the object to delete.
     *
     * @return Response
     * @throws ORMException
     */
    public function deleteJson(
        Request $request,
        EntityManagerInterface $entityManager,
        string $objectClass,
        string $successMessage,
        string $confirmationMessage,
        int $entityId
    ): Response {
        $form = $this->createForm(ConfirmationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $entityManager->getReference($objectClass, $entityId);
            $entityManager->remove($entity);
            $entityManager->flush();
            $this->addFlash('success', $successMessage);

            return $this->json(['id' => 0]);
        }
        return $this->render(
            '@AtournayreToolbox/Form/_partial/form/_delete.html.twig',
            [
                'form' => $form->createView(),
                'messageConfirmation' => $confirmationMessage,
            ]
        );
    }
}
