<?php

namespace App\Form;

use App\Entity\Course;
use App\Repository\VoitureRepository;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseUserForm extends AbstractType
{

   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('destination')
            ->add('depart')
            ->add('dateCourse')
            ->add('nbPersonne')
          
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
