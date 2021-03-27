<?php

namespace App\Form;

use App\Entity\Oeuvre;
use App\Entity\YearDirectory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('year',TextType::class,[
                'label' => 'Titre *',
                'required' => true,
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => [
                    'class' => 'field',
                    ],
                'attr' => [
                    'class' => 'input has-text-centered',
                    'placeholder' => 'Ex : Mariage',
                ],
                'help' => 'Nommez cette galerie avec quelques mots. Exemple : une année / un nom',
                'help_attr' => ['class' => 'help'],
                'constraints' => [
                  new Length([
                      'max' => 25,
                      'maxMessage' => 'Le titre est trop long . . . (25 char. max)'
                  ]),
                  new NotBlank([
                      'message' => 'Ce champs ce ne peut être vide'
                  ])
                ],
            ])
            ->add('title',TextareaType::class,[
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
            ->add('file', FileType::class,[
                'label' => 'Image de couverture',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class' => 'field is-flex is-flex-direction-column'],
                'attr' => [
                    'class' => 'has-text-centered'
                ],
                'error_bubbling' => true,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => YearDirectory::class,
        ]);
    }
}
