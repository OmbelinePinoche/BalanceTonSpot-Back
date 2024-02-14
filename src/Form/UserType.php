<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TypeTextType::class, [
                'label' => 'Prénom: '
            ])
            ->add('lastname', TypeTextType::class, [
                'label' => 'Nom: '
            ])
            ->add('username', TypeTextType::class, [
                'label' => 'Pseudo'
            ])
            ->add('email', TypeTextType::class, [
                'label' => 'Email'
            ])
            ->add('roles', TypeTextType::class, [
                'label' => 'Rôle'
            ])
            ->add('password', TypeTextType::class, [
                'label' => 'Mot de passe'
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
