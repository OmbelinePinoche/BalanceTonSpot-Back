<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
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
            ->add('profilpicture', FileType::class, [
                'label' => 'Photo de profil: '
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle: ',
                'choices' => [
                    'Rider' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'multiple' => true
            ])
            ->add('password', TypeTextType::class, [
                'label' => 'Mot de passe: '
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
