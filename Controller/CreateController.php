<?php

namespace Atournayre\ToolboxBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends AbstractController
{
    const ACTION_CREATE_JSON = __CLASS__ . '::createJson';

    /**
     * Use with $this->forward()
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param string                 $serializedEntity  The entity (must be serialized because of ParamConverter).
     * @param string                 $formType          The form type used to persist entity.
     * @param string                 $successMessage    The message if success.
     * @param string                 $formTemplate      The form template.
     * @param array                  $formOptions       The form type options.
     * @param string|null            $errorMessage      The message if an error occurs.
     * @param array                  $otherResults      If JSON needs some additional parameters.
     * @param array                  $otherParams       If the form need other parameters for rendering.
     *
     * @return Response
     */
    public function createJson(
        Request $request,
        EntityManagerInterface $entityManager,
        string $serializedEntity,
        string $formType,
        string $successMessage,
        string $formTemplate,
        array $formOptions = [],
        ?string $errorMessage = null,
        array $otherResults = [],
        array $otherParams = []
    ): Response {
        $entity = unserialize($serializedEntity);
        $form = $this->createForm($formType, $entity, $formOptions);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($entity);
                $entityManager->flush();
                $entityManager->refresh($entity);
                $this->addFlash('success', $successMessage);
                $result = array_merge(
                    ['id' => $entity->getId()],
                    $otherResults
                );
            } catch (Exception $exception) {
                $this->addFlash(
                    'error',
                    sprintf(
                        '%s %s',
                        $errorMessage ?? 'An error occured.',
                        $exception->getMessage()
                    )
                );
            } finally {
                return $this->json($result ?? []);
            }
        }

        return $this->render(
            $formTemplate,
            array_merge(
                ['form' => $form->createView()],
                $otherParams
            )
        );
    }
}
