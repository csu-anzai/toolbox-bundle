<?php

namespace Atournayre\ToolboxBundle\Form\Address;

use Atournayre\ToolboxBundle\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    const LINE_MAXLENGTH = 38;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'line1',
                TextType::class,
                [
                    'label' => 'Line 1',
                    'required' => false,
                    'attr' => [
                        'maxlength' => self::LINE_MAXLENGTH,
                    ]
                ]
            )
            ->add(
                'line2',
                TextType::class,
                [
                    'label' => 'Line 2',
                    'required' => false,
                    'attr' => [
                        'maxlength' => self::LINE_MAXLENGTH,
                    ]
                ]
            )
            ->add(
                'line3',
                TextType::class,
                [
                    'label' => 'Line 3',
                    'required' => false,
                    'attr' => [
                        'maxlength' => self::LINE_MAXLENGTH,
                    ]
                ]
            )
            ->add(
                'line4',
                TextType::class,
                [
                    'label' => 'Line 4',
                    'required' => false,
                    'attr' => [
                        'maxlength' => self::LINE_MAXLENGTH,
                    ]
                ]
            )
            ->add(
                'line5',
                TextType::class,
                [
                    'label' => 'Line 5',
                    'required' => false,
                    'attr' => [
                        'maxlength' => self::LINE_MAXLENGTH,
                    ]
                ]
            )
            ->add(
                'line6',
                TextType::class,
                [
                    'label' => 'Line 6',
                    'required' => false,
                    'attr' => [
                        'maxlength' => self::LINE_MAXLENGTH,
                    ]
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
