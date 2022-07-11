<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Job;
use App\Entity\Agency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (in_array('ROLE_SUPER_ADMIN', $options['role'])) {
            $builder
                ->add('email', EmailType::class,
                    [
                        'label' => false,
                        'attr' => array('class' => 'form-control'),
                    ]
                )
                ->add('firstname', TextType::class,
                    [
                        'label' => false,
                        'attr' => array('class' => 'form-control', 'readonly' => true,),
                    ]
                )
                ->add('lastname', TextType::class,
                    [
                        'label' => false,
                        'attr' => array('class' => 'form-control', 'readonly' => true,),
                    ]
                )
                ->add('agency', EntityType::class,
                    [
                        'class' => Agency::class,
                        'attr' => array('class' => 'form-control'),
                        'choice_label' => 'name',
                        'label' => false,
                        'multiple' => false,
                        'expanded' => false,
                    ]
                )
                ->add('job', EntityType::class,
                    [
                        'class' => Job::class,
                        'attr' => array('class' => 'form-control'),
                        'choice_label' => 'name',
                        'label' => false,
                        'multiple' => true,
                        'expanded' => false,
                    ]
                )
                ->add('roles', ChoiceType::class,
                    [
                        'label' => false,
                        'attr' => array('class' => 'form-control'),
                        'choices' =>
                        [
                            'Utilisateur' => 'ROLE_USER',
                            'Admin' => 'ROLE_ADMIN',
                            'Super Admin' => 'ROLE_SUPER_ADMIN'
                        ],
                        'multiple' => true,
                        'required' => true,
                    ]
                )
                ->add('isAvailable', ChoiceType::class,
                    [
                        'label' => false,
                        'attr' => array('class' => 'form-control'),
                        'choices' =>
                        [
                            'Je suis disponible' => true,
                            'Je ne suis pas disponible' => false,
                        ],
                        'multiple' => false,
                        'required' => true,
                    ]
                )
                ->add('password', PasswordType::class,
                    [
                        'label' => 'Mot de passe',
                        'attr' => array('class' => 'form-control'),
                        'disabled' => true,
                    ]
                )
            ;
        } else {
            $builder
                ->add('email', EmailType::class,
                    [
                        'label' => false,
                        'attr' => array('class' => 'form-control'),
                        'disabled' => true,
                    ]
                )
                ->add('firstname', TextType::class,
                    [
                        'label' => false,
                        'attr' => array('class' => 'form-control', 'readonly' => true,),
                        'disabled' => true,
                    ]
                )
                ->add('lastname', TextType::class,
                    [
                        'label' => false,
                        'attr' => array('class' => 'form-control', 'readonly' => true,),
                        'disabled' => true,
                    ]
                )
                ->add('agency', EntityType::class,
                    [
                        'class' => Agency::class,
                        'attr' => array('class' => 'form-control'),
                        'choice_label' => 'name',
                        'label' => false,
                        'multiple' => false,
                        'expanded' => false,
                        'disabled' => true,
                    ]
                )
                ->add('job', EntityType::class,
                    [
                        'class' => Job::class,
                        'attr' => array('class' => 'form-control'),
                        'choice_label' => 'name',
                        'label' => false,
                        'multiple' => true,
                        'expanded' => false,
                        'disabled' => true,
                    ]
                )
                ->add('roles', ChoiceType::class,
                    [
                        'label' => false,
                        'attr' => array('class' => 'form-control'),
                        'choices' =>
                        [
                            'Utilisateur' => 'ROLE_USER',
                            'Admin' => 'ROLE_ADMIN',
                            'Super Admin' => 'ROLE_SUPER_ADMIN'
                        ],
                        'multiple' => true,
                        'required' => true,
                        'disabled' => true,
                    ]
                )
                ->add('isAvailable', ChoiceType::class,
                    [
                        'label' => false,
                        'attr' => array('class' => 'form-control'),
                        'choices' =>
                        [
                            'Je suis disponible' => true,
                            'Je ne suis pas disponible' => false,
                        ],
                        'multiple' => false,
                        'required' => true,
                    ]
                )
                ->add('password', PasswordType::class,
                    [
                        'label' => 'Mot de passe',
                        'attr' => array('class' => 'form-control'),
                    ]
                )
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'role' => ['ROLE_USER']
        ]);
    }
}
