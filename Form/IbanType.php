<?php

namespace Atournayre\ToolboxBundle\Form;

use Atournayre\ToolboxBundle\DataTransformer\IbanTransformer;
use Atournayre\ToolboxBundle\Entity\Iban;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class IbanType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'iban',
                TextType::class,
                [
                    'label' => 'IBAN',
                    'constraints' => [
                        new NotBlank('IBAN is mandatory.'),
                        // Validation de l'IBAN
                    ]
                ]
            )
            ->add(
                'swift',
                TextType::class,
                [
                    'label' => 'SWIFT',
                    'constraints' => [
                        new NotBlank('SWIFT is mandatory.'),
                    ]
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Iban::class,
       ]);
    }
}