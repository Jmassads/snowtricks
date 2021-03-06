<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration('Prénom', "Votre prénom..."))
            ->add('LastName', TextType::class, $this->getConfiguration('Nom', "Votre nom de famille..."))
            ->add('username', TextType::class, $this->getConfiguration("Nom d'utilisateur", "Votre nom d'utilisateur"))
            ->add('email', EmailType::class, $this->getConfiguration('Email', "Votre adresse email..."))
            ->add('picture', UrlType::class, $this->getConfiguration('Photo de profil', "url de votre avatar..."))
            ->add('hash', PasswordType::class, $this->getConfiguration('Mot de passe', "Choisissez un bon mot de passe..."))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration('Confirmation de mot de passe', "Veuillez confirmer votre mot de passe..."))
            ->add('introduction', TextType::class, $this->getConfiguration('Introduction', "Présentez vous en quelques mots..."))
            ->add('description', TextareaType::class, $this->getConfiguration('Description détaillée', "C'est le moment de vous présenter en détail"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
