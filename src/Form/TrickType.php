<?php

namespace App\Form;

use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    /** Permet d'avoir la configuration de base d'un champs
     * @param $label
     * @param $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre', 'Veuillez tapez un super titre pour votre figure!'))
            ->add('slug', TextType::class, $this->getConfiguration('Adresse web', "Tapez l'adresse web (automatique)"))
            ->add('description', TextareaType::class, $this->getConfiguration('Description', 'Tapez une description détaillée pour votre figure!'))
            ->add('coverImage', UrlType::class, $this->getConfiguration('Url de l\'image', 'Donnez l\'adresse web d\'une image pour votre figure!'))
            ->add('images', Collectiontype::class,
                [
                    'entry_type' => ImageType::class
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
