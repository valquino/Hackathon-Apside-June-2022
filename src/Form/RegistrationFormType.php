<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Agency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, array
            (
            'label' => 'prénom : ',
            ))
            ->add('lastname', TextType::class, array
            (
            'label' => 'nom : : ',
            ))
            ->add('roles', ChoiceType::class, array(
                'attr' => array('class' => 'form-control'),
                'choices' => 
                array
                (
                    'Utilisateur' => 'ROLE_USER',
                    'Plop' => 'ROLE_ADMIN',
                    'Plop2' => 'ROLE_SUPER_ADMIN'
                ),
                'multiple' => true,
                'required' => true,
            ))
            ->add('is_available', ChoiceType::class, array(
                'attr' => array('class' => 'form-control'),
                'label' => 'Disponible?',
                'choices' =>
                array
                (
                    'Disponible' => 'Oui',
                    'Indisponible' => 'Non',
                )
            ))
            ->add('email')
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux champs doivent correspondre',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rentrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('Agency', EntityType::class, [
                'class' => Agency::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])

            ->add('is_admin', ChoiceType::class, array(
                'choices' =>
                array
                (
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
