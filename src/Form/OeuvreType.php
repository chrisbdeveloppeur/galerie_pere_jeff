<?php

namespace App\Form;

use App\Entity\Oeuvre;
use App\Entity\YearDirectory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('file', FileType::class,[
                'error_bubbling' => true,
                'required' => false,
            ])
            ->add('annee')
            ->add('year_directory', EntityType::class,[
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
