<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',TextType::class,[
                'error_bubbling' => true,
                'label' => 'Email',
                'label_attr' => ['class'=>'has-text-weight-bold'],
                'row_attr' => ['class'=>'mb-4'],
                'attr' => [
                    'class' => 'input has-text-centered',
                    'placeholder' => 'Ex : monemail@gmail.com',
                ],
            ])
//            ->add('roles')
            ->add('password', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe indiqués ne sont pas identiques',
                'options' => ['attr' => ['class' => 'password-field input']],
                'required' => true,
                'error_bubbling' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'label_attr' => ['class'=>'has-text-weight-bold'],
                    'row_attr' => ['class'=>'mb-4'],
                ],
                'second_options' => [
                    'label' => 'Retappez votre mot de passe',
                    'label_attr' => ['class'=>'has-text-weight-bold'],
                    'required' => true,
                    'row_attr' => ['class'=>'mb-4'],
                    ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
