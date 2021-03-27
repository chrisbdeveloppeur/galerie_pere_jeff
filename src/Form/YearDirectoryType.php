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
            ->add('year',TextType::class,[
                'label' => 'Titre',
                'required' => false,
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class' => 'field'],
                'attr' => [
                    'class' => 'input has-text-centered'
                ]
            ])
            ->add('title',TextType::class,[
                'label' => 'Description',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class' => 'field'],
                'attr' => [
                    'class' => 'input has-text-centered'
                ]
            ])
            ->add('file', FileType::class,[
                'label' => 'Image de couverture',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class' => 'field is-flex is-flex-direction-column'],
                'attr' => [
                    'class' => 'has-text-centered'
                ],
                'error_bubbling' => true,
                'required' => false,
                'help' => 'Si aucun fichier n\'est uploadé, l\'image de la première oeuvre de la gallerie sera affichée en couverture',
                'help_attr' => ['class' => 'help']
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
