<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Spot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('spot', EntityType::class, [
                'class' => Spot::class,
                'choice_label' => 'name', 'label' => 'Spot concerné'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Commentaire'
            ])
            ->add('rating', ChoiceType::class, [
                'label' => 'Note',
                'choices' => [
                    '0/5' => 0,
                    '1/5' => 1,
                    '1.5/5' => 1.5,
                    '2/5' => 2,
                    '2.5/5' => 2.5,
                    '3/5' => 3,
                    '3.5/5' => 3.5,
                    '4/5' => 4,
                    '4.5/5' => 4.5,
                    '5/5' => 5
                ]
            ])
            ->add('date', DateType::class, [
                'label' => 'Ajouté le'
            ])
            ->add('user', null, [
                'label' => 'Par',
                'mapped' => false, 
                'data' => $options['user'], // Set the username as default data
                'attr' => [
                    'disabled' => true,
                ],
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'user' => null
        ]);
    }
}
