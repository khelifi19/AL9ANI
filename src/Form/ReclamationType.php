<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NomReclamation', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Votre Nom est requis.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z\s]*$/',
                        'message' => 'Votre Nom ne doit pas contenir de chiffres.',
                    ]),
                ],
            ])
            ->add('PrenomReclamation', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Votre Prénom est requis.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z\s]*$/',
                        'message' => 'Votre Prénom ne doit pas contenir de chiffres.',
                    ]),
                ],
            ])
            ->add('titreReclamation')
            ->add('emailReclamation', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ Email est requis.',
                    ]),
                    new Assert\Email([
                        'message' => 'L\'email "{{ value }}" n\'est pas valide.',
                    ]),
                ],
            ])
            ->add('descriptionReclamation');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}

