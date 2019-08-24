<?php

namespace Atournayre\ToolboxBundle\Controller;

use Atournayre\ToolboxBundle\Form\ConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteController extends AbstractController
{
    const ACTION_DELETE_JSON = __CLASS__ . '::deleteJson';

    /**
     * Use with $this->forward()
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param string                 $objectClass         The FQDN of the object to delete.
     * @param int                    $entityId            The id of the object to delete.
     * @param string                 $successMessage      The message if success.
     * @param string                 $confirmationMessage The confirmation message.
     * @param string                 $errorMessage        The message is an error occurs.
     *
     * @return Response
     */
    public function deleteJson(
        Request $request,
        EntityManagerInterface $entityManager,
        string $objectClass,
        int $entityId,
        ?string $successMessage = null,
        ?string $confirmationMessage = null,
        ?string $errorMessage = null
    ): Response {
        $form = $this->createForm(ConfirmationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entity = $entityManager->getReference($objectClass, $entityId);
                $entityManager->remove($entity);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    $successMessage
                        ?? $this->getParameter('atournayre_toolbox.crud_controller.delete.default_success_message')
                );
                $result = ['id' => 0];
            } catch (Exception $exception) {
                $this->addFlash(
                    'error',
                    $errorMessage
                    ?? $this->getParameter('atournayre_toolbox.crud_controller.delete.default_error_message')
                );
            } finally {
                return $this->json($result ?? ['id' => $entityId]);
            }
        }

        return $this->render(
            $this->getParameter('atournayre_toolbox.crud_controller.delete.form_template'),
            [
                'form' => $form->createView(),
                'messageConfirmation' => $confirmationMessage
                    ?? $this->getParameter('atournayre_toolbox.crud_controller.delete.default_confirmation_message'),
            ]
        );
    }
}
