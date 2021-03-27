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
                ],
                'help' => 'Nommez cette galerie avec quelques mots',
                'help_attr' => ['class' => 'help'],
                'constraints' => [
                  new Length(['max' => 25, 'maxMessage' => 'Le titre est trop long']),
                ],
            ])
            ->add('title',TextareaType::class,[
                'label' => 'Sous-titre',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class' => 'field'],
                'attr' => [
                    'class' => 'textarea has-text-centered',
                    'style' => 'resize:none;',
                ],
                'constraints' => [
                    new Length(['max' => 150, 'maxMessage' => 'Le sous-titre est trop long']),
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
//                'help' => 'Si aucun fichier n\'est uploadé, l\'image de la première oeuvre de la gallerie sera affichée en couverture',
//                'help_attr' => ['class' => 'help']
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
