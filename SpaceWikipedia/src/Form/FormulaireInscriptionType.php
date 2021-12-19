<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class FormulaireInscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [ 'label'=> 'Adresse mail', 'attr' => ['class' => 'form-control', 'placeholder' => 'Adresse mail']])
            ->add('password', PasswordType::class, ['label'=> "Mot de passe", 'attr' => ['class' => 'form-control', 'placeholder' => 'Mot de passe']])
            ->add('confirm_password', PasswordType::class, ['label'=> "Confirmer mot de passe", 'attr' => ['class' => 'form-control', 'placeholder' => 'Confirmer mot de passe']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
