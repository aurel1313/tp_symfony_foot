<?php

namespace App\Form;

use App\Entity\ArticlesFoot;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Add this line
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticleFootType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('images',FileType::class,[
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new File([
                        'maxSize'=>'5000k',
                        'mimeTypes'=>['image/png',
                             'image/jpeg'
                            ],
                        'mimeTypesMessage' => 'Please upload a valid png document'
                    ])
                ]
            ])
           /*->add('user',EntityType::class,[
               'class'=>User::class,
                'choice_label'=>'pseudo'
               
               ])*/
            ->add('submit' ,SubmitType::class,[
                'label'=>'Enregistrer'
            ]  );

           



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticlesFoot::class,
        ]);
    }
}
