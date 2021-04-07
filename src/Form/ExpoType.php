<?php

namespace App\Form;

use App\Entity\Expo;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text',CKEditorType::class,[
                'config' => ['toolbar' => 'full'],
                'error_bubbling' => true,
                'label' => 'Contenu de la rubrique "exposition"',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class'=>'mb-4'],
                'attr' => [
                    'class' => 'textarea has-text-centered'
                ],
                'required' => true,
//                'help' => 'Entrez les éléments du menu "slide"',
//                'help_attr' => ['class' => 'help'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Expo::class,
        ]);
    }
}
