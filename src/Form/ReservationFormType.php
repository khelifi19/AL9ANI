<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Pass;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $evenements = $options['evenements'];
        $passes = $options['passes'];

        $builder
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                'choices' => $evenements,
                'choice_label' => 'nomEvent',
            ])
            ->add('pass', EntityType::class, [
                'class' => Pass::class,
                'choices' => $passes,
                'choice_label' => 'type',
                'query_builder' => function (EntityRepository $er) use ($evenements) {
                    return $er->createQueryBuilder('p')
                        ->where('p.evenement IN (:evenements)')
                        ->setParameter('evenements', $evenements);
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['evenements', 'passes']);
    }
}