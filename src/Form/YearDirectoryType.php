<?php

namespace App\Form;

use App\Entity\YearDirectory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YearDirectoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'label' => 'Titre',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'attr' => [
                    'class' => 'input has-text-centered'
                ]
            ])
            ->add('year',TextType::class,[
                'label' => 'Année',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'attr' => [
                    'class' => 'input has-text-centered'
                ]
            ])
            ->add('file', FileType::class,[
                'label' => 'Fichier',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'attr' => [
                    'class' => 'has-text-centered'
                ],
                'error_bubbling' => true,
                'required' => false,
            ])
//            ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => YearDirectory::class,
        ]);
    }
}
