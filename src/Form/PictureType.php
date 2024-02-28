<?php

namespace App\Form;

use App\Entity\Picture;
use App\Entity\Spot;
use App\Form\FileTransformer as FormFileTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'image',
            ])
            ->add('path', FileType::class, [
                'label' => 'Image',
                'mapped' => false, // To prevent Symfony from trying to map the field to an entity property
            ])
            ->add('spot', EntityType::class, [
                'class' => Spot::class,
                'choice_label' => 'name', 'label' => 'A quel spot voulez-vous associer cette image?'
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
        $builder->get('path')->addModelTransformer(new FormFileTransformer());
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}
