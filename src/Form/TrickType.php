<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Tricks;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre', 'Veuillez tapez un super titre pour votre figure!'))
            ->add(
                'slug',
                TextType::class,
                $this->getConfiguration('Adresse web', "Tapez l'adresse web (automatique)" ,[
                    'required' => false
                ])
            )
            ->add('description', TextareaType::class, $this->getConfiguration('Description', 'Tapez une description détaillée pour votre figure!'))
            ->add('coverImage', UrlType::class, $this->getConfiguration('Url de l\'image', 'Donnez l\'adresse web d\'une image pour votre figure!'))
            ->add('images', Collectiontype::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true
                ]
            )
            ->add('videos', Collectiontype::class,
                [
                    'entry_type' => VideoType::class,
                    'allow_add' => true
                ]
            )

            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => Categories::class,

                // uses the User.username property as the visible option string
                'placeholder' => 'Toutes les catégories', // add All option to beginning
                'choice_label' => 'title',
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
