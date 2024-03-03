<?php

namespace App\Form;

use App\Entity\Chauffeur;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('chauffeur', EntityType::class, [ // Ajout du champ chauffeur de type EntityType
                'class' => Chauffeur::class, // Entité cible
                'choice_label' => function ($chauffeur) { // Fonction pour définir comment afficher les choix
                    return $chauffeur->getNom() . ' ' . $chauffeur->getPrenom(); // Affichage du nom et prénom du chauffeur
                },
                'placeholder' => 'Choisir un chauffeur', // Texte par défaut
                'required' => false, // Le champ n'est pas obligatoire
            ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
