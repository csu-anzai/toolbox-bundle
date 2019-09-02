<?php

namespace Atournayre\ToolboxBundle\Form\Address;

use Atournayre\ToolboxBundle\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressProfessionalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->get('line1')->setAttribute('label', 'Raison Sociale/Dénomination commerciale')
            ->get('line2')->setAttribute('label', 'Identité du destinataire/Service')
            ->get('line3')->setAttribute('label', 'Entrée - Bâtiment - Immeuble - Résidence ...')
            ->get('line4')->setAttribute('label', 'Rue - Avenue - Hameau ...')
            ->get('line5')->setAttribute('label', 'BP, TSA ...')
            ->get('city')->setAttribute('label', 'Code postal et Localite/Code cedex')
            ;
    }

    /**
     * @return string
     */
    public function getParent(): string
    {
        return AddressType::class;
    }
}
