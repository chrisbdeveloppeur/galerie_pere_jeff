<?php

namespace App\Form;

use App\Entity\TextMenuBurger;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextMenuBurgerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text',CKEditorType::class,[
                'config' => ['toolbar' => 'full'],
                'error_bubbling' => true,
                'label' => 'Text de la biographie',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class'=>'mb-4'],
                'attr' => [
                    'class' => 'textarea has-text-centered'
                ],
                'required' => true,
//                'help' => 'Entrez les éléments du menu "slide"',
//                'help_attr' => ['class' => 'help'],
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TextMenuBurger::class,
        ]);
    }
}
