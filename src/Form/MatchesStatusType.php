<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Add this line

class MatchesStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En cours' => 'LIVE',
                    'Programmé' => 'SCHEDULED',
                    'Terminé' => 'FINISHED',
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Chosissez un type de match',
            ])  

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
