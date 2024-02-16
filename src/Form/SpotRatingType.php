<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Sport;
use App\Entity\Spot;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpotRatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('picture')
            ->add('address')
            ->add('rating')
            ->add('slug')
            ->add('sport_id', EntityType::class, [
                'class' => Sport::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
'choice_label' => 'id',
            ])
            ->add('user_favorite', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Spot::class,
        ]);
    }
}
