<?php

namespace App\Form;

use App\Entity\GroupeGaleries;
use App\Entity\Oeuvre;
use App\Entity\YearDirectory;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,[
                'error_bubbling' => true,
                'label' => 'Titre',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class'=>'mb-4'],
                'attr' => [
                    'class' => 'input has-text-centered',
                    'placeholder' => 'Ex : Ma belle photo',
                ],
                'help' => 'Nommez cette oeuvre',
                'help_attr' => ['class' => 'help'],
            ])
            ->add('file', FileType::class,[
                'error_bubbling' => true,
                'label' => 'Fichier image',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class'=>'field is-flex is-flex-direction-column'],
                'attr' => [
                    'class' => 'has-text-centered'
                ],
                'required' => false,
                'help' => 'Types de fichier autorisé : .jpg .png .svg .bmp',
                'help_attr' => ['class' => 'help']
            ])
            ->add('description',CKEditorType::class,[
                'error_bubbling' => true,
                'config' => ['toolbar' => 'config_custom_min'],
                'label' => 'Description',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class'=>'mb-4'],
                'attr' => [
                    'class' => 'textarea has-text-centered'
                ],
                'required' => true,
                'help' => 'Entrez éventuellement la description de cette oeuvre',
                'help_attr' => ['class' => 'help'],
            ])
            ->add('year',NumberType::class,[
                'error_bubbling' => true,
                'label' => 'Année',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class'=>'mb-4'],
                'attr' => [
                    'class' => 'input has-text-centered',
                    'placeholder' => 'Ex : 2010',
                ],
                'help' => 'Indiquer l\'année de l\'oeuvre',
                'help_attr' => ['class' => 'help'],
            ])
            ->add('year_directory', EntityType::class,[
                'error_bubbling' => true,
                'class' => YearDirectory::class,
                'required' => false,
                'label' => false,
                'placeholder' => '',
                'row_attr' => [
                    'class' => 'select is-fullwidth',
                ],
                'attr' => [
                    'class' => 'has-text-centered has-font-poppins'
                ],
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
