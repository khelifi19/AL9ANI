<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modele', ChoiceType::class, [
                'choices' => [
                   
                    'Classique' => 'Classique',
                    'Bus'  =>'Bus',
                ],
                'placeholder' => 'Choisir un modèle',
            ])
         
          
            ->add('disponibilite', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true, // pour afficher les boutons radio au lieu d'une liste déroulante
                'multiple' => false, // pour n'autoriser qu'un seul choix
                'label' => 'Disponibilité',
            ])
            ->add('matricule')
            ->add('description')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
