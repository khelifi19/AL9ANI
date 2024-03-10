<?php

namespace App\Form;

use App\Entity\Course;
use App\Repository\VoitureRepository;
use App\Repository\EtablissementsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseUserForm extends AbstractType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {$etablissementsRepository = $options['etablissements_repository'];
        $etablissements = $etablissementsRepository->findAll();
        $choices = [];
        foreach ($etablissements as $etablissement) {
            $choices[$etablissement->getNom()] = $etablissement->getNom();
        }
    
        $builder
        ->add('destination', ChoiceType::class, [
            'choices' => $choices,
            'placeholder' => 'Choisir votre destination',
        ])
            ->add('depart')
     
            ->add('nbPersonne')
       
            ->add('date', DateTimeType::class, [
                'label' => 'Date et Heure',
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Date et Heure',
                ]
            ]);
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
            'etablissements_repository' => null, 
        ]);
    }
}
