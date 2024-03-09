<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TypeTextType::class, [
                'label' => 'Prénom: ',
                'required' => false,
            ])
            ->add('lastname', TypeTextType::class, [
                'label' => 'Nom: ',
                'required' => false,
            ])
            ->add('pseudo', TypeTextType::class, [
                'label' => 'Pseudo: '
            ])
            ->add('email', TypeTextType::class, [
                'label' => 'Email: '
            ])
            ->add('profilPictureFile', FileType::class, [
                'label' => 'Image du profil: ',
                'mapped' => false, // To prevent Symfony from trying to map the field to an entity property
                'required' => false,
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle: ',
                'choices' => [
                    'Rider' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'multiple' => true
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe: ',
                'attr' => [
                    'placeholder' => '*********************',
                    'disabled' => $options['is_authenticated'],
                ],
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_authenticated' => false,
        ]);
    }
}
