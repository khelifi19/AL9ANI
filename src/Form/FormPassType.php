<?php

namespace App\Form;

use App\Entity\Pass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prixPass')
            ->add('type')
            ->add('evenement', ChoiceType::class, [
                'choices' => $options['evenements'],
                'choice_label' => 'nomEvent', // Adjust this based on your Evenement entity properties
                'label' => 'Associated Evenement',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pass::class,
            'evenements' => [], // Define the 'evenements' option
        ]);
    }
}