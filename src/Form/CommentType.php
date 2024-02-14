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
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;


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
            ->add('date', DateType::class, [
                'label' => 'Ajouté le'
            ])
            ->add('username', TypeTextType::class, [
                'label' => 'Par'
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
