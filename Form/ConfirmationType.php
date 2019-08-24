<?php

namespace Atournayre\ToolboxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfirmationType extends AbstractType
{
    const ACTION_CONFIRM = 'confirm';

    /**
     * @var string
     */
    private $buttonLabel;

    /**
     * ConfirmationType constructor.
     *
     * @param string $buttonLabel
     */
    public function __construct(string $buttonLabel)
    {
        $this->buttonLabel = $buttonLabel;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                self::ACTION_CONFIRM,
                SubmitType::class,
                [
                    'label' => $this->buttonLabel,
                ]
            );
    }
}