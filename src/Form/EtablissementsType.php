<?php

namespace App\Form;

use App\Entity\Etablissements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;

class EtablissementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('categorie')
            ->add('adress')
            ->add('mail', EmailType::class, ['label' => 'Email'])
            ->add('tel', IntegerType::class, ['label' => 'Numéro De Téléphone'])
            ->add('recaptcha', Recaptcha3Type::class, [
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\NotBlank(),
                    new \Symfony\Component\Validator\Constraints\Length(['min' => 3]),
                ],
                'action_name' => 'app_etablissements_index', // Remplacez 'contact' par le nom de votre action
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etablissements::class,
        ]);
    }
}
