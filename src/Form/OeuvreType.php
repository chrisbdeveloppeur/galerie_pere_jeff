<?php

namespace App\Form;

use App\Entity\Oeuvre;
use App\Entity\YearDirectory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,[
                'label' => 'Titre',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'attr' => [
                    'class' => 'input has-text-centered'
                ]
            ])
            ->add('description',TextType::class,[
                'label' => 'Description',
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
            ->add('year_directory', EntityType::class,[
                'label' => 'Année',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'attr' => [
                    'class' => 'has-text-centered'
                ],
                'class' => YearDirectory::class,
                'choice_label' => 'year',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Oeuvre::class,
        ]);
    }
}
