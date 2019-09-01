<?php

namespace Atournayre\ToolboxBundle\Form\Address;

use Atournayre\ToolboxBundle\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressIndividualTypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->get('line1')->setAttribute('label', 'Civilité/Titre Prénom Nom')
            ->get('line2')->setAttribute('label', 'N° appartement ou de boite à lettre – Etage – Couloir - Escalier')
            ->get('line3')->setAttribute('label', 'Entrée - Bâtiment - Immeuble - Résidence ...')
            ->get('line4')->setAttribute('label', 'Rue - Avenue - Hameau ...')
            ->get('line5')->setAttribute('label', 'Poste restante - BP - Lieu-dit ...')
            ->get('line6')->setAttribute('label', 'Code postal et Localite')
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
