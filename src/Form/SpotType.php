<?php

namespace App\Form;

use App\Entity\Spot;
use App\Entity\Sport;
use App\Entity\Location;
use App\Form\FileTransformer as FormFileTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SpotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class, [
                'label' => 'Nom'
            ])
            ->add('sport_id', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'name',
                'label' => 'Sport concerné',
                'multiple' => true,
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
                'label' => 'Ville',
            ])
            ->add('address', TypeTextType::class, [
                'label' => 'Adresse'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image principale',
                'mapped' => false, // To prevent Symfony from trying to map the field to an entity property
                'required' => false,
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
        $builder->get('picture')->addModelTransformer(new FormFileTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Spot::class,
        ]);
    }
}
