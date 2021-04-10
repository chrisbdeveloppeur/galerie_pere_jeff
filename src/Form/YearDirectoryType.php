<?php

namespace App\Form;

use App\Entity\Oeuvre;
use App\Entity\YearDirectory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class YearDirectoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('yearStart',NumberType::class,[
                'error_bubbling' => true,
                'label' => 'Année (début) *',
                'required' => true,
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => [
                    'class' => 'control',
                ],
                'attr' => [
                    'class' => 'input has-text-centered',
                    'placeholder' => 'Ex : 2000',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ce ne peut être vide'
                    ])
                ],
            ])
            ->add('yearEnd',NumberType::class,[
                'error_bubbling' => true,
                'label' => 'Année (fin) *',
                'required' => true,
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => [
                    'class' => 'control',
                ],
                'attr' => [
                    'class' => 'input has-text-centered',
                    'placeholder' => 'Ex : 2010',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ce ne peut être vide'
                    ])
                ],
            ])
            ->add('title',TextareaType::class,[
                'error_bubbling' => true,
                'label' => 'Sous-titre',
                'required' => false,
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class' => 'field'],
                'attr' => [
                    'class' => 'textarea has-text-centered',
                    'style' => 'resize:none;',
                    'placeholder' => 'Ex : Immortalisation des moments merveilleux',
                ],
                'help' => 'Donnez un sous-titre succinct et pertinent à cette galerie (description)',
                'help_attr' => ['class' => 'help'],
                'constraints' => [
                    new Length([
                        'max' => 150,
                        'maxMessage' => 'Le sous-titre est trop long . . . (150 char. max)'
                    ]),
                ],
            ])
//            ->add('file', FileType::class,[
//                'error_bubbling' => true,
//                'label' => 'Image de couverture',
//                'label_attr' => ['class'=>'has-text-weight-bold'],
//                'row_attr' => ['class' => 'field is-flex is-flex-direction-column'],
//                'attr' => [
//                    'class' => 'has-text-centered'
//                ],
//                'required' => false,
//                'help' => 'Types de fichier autorisé : .jpg .png .svg .bmp',
//                'help_attr' => ['class' => 'help']
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => YearDirectory::class,
        ]);
    }
}
