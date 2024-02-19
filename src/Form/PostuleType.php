<?php

namespace App\Form;

use App\Entity\Postule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostuleType extends AbstractType
{
   

    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        $villes = [
        'Tunis', 'Sfax', 'Sousse', 'Ettadhamen-Mnihla', 'Kairouan', 'Gabès', 'Bizerte', 'Ariana', 'Gafsa', 
        'La Marsa', 'Zarzis', 'Médenine', 'Tataouine', 'Béja', 'Nabeul', 'Ben Arous', 'El Mourouj', 'Sfax', 
        'Mahdia', 'Kasserine', 'Menzel Bourguiba', 'Monastir', 'Manouba', 'Rades'
    ];
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('ville', ChoiceType::class, [
                'choices' => array_combine($villes, $villes),
            ])
            ->add('age')
            ->add('numero')
            ->add('email')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Postule::class,
        ]);
    }
}
