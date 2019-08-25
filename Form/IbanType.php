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
     * @var IbanTransformer
     */
    private $ibanTransformer;

    /**
     * IbanType constructor.
     *
     * @param IbanTransformer $ibanTransformer
     */
    public function __construct(IbanTransformer $ibanTransformer)
    {
        $this->ibanTransformer = $ibanTransformer;
    }

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

        $builder->get('iban')->addModelTransformer($this->ibanTransformer);
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