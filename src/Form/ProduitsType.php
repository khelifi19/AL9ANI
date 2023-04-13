<?php

namespace App\Form;

use App\Entity\Produits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productName')
            ->add('productDescription')
            ->add('productPhoto')
            ->add('productPrice')
            //->add('relatedArtist')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
