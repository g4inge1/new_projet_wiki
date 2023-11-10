<?php

namespace App\Form;

use App\Entity\ActuelleFiche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Ajoutez cette ligne
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActuelleFicheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('contenu')
            ->add('description')
            ->add('auteur')
            ->add('dateCreation')
            ->add('idCategories')
            ->add('save', SubmitType::class, [ // Ajoutez cette ligne pour le bouton de soumission
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn btn-primary'], // Vous pouvez personnaliser les classes CSS ici
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActuelleFiche::class,
        ]);
    }
}
