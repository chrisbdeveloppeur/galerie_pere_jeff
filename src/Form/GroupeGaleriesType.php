<?php

namespace App\Form;

use App\Entity\GroupeGaleries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeGaleriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('yearStart',NumberType::class,[
                'error_bubbling' => true,
                'label' => 'Année de début',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class'=>'mb-4'],
                'attr' => [
                    'class' => 'input has-text-centered',
                    'placeholder' => 'Ex : 2000',
                ],
                'help' => 'Indiquez l\'année de début',
                'help_attr' => ['class' => 'help'],
            ])
            ->add('yearEnd',NumberType::class,[
                'error_bubbling' => true,
                'label' => 'Année de fin',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class'=>'mb-4'],
                'attr' => [
                    'class' => 'input has-text-centered',
                    'placeholder' => 'Ex : 2000',
                ],
                'help' => 'Indiquez l\'année de fin',
                'help_attr' => ['class' => 'help'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupeGaleries::class,
        ]);
    }
}
