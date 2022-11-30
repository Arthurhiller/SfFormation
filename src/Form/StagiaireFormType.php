<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'form-input']
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'form-input']
            ])
            ->add('dateNaissance', DateType::class, [
                'required' => true,
                'attr' => ['class' => 'form-input']
            ])
            ->add('sexe', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'form-input']
            ])
            ->add('ville', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'form-input']
            ])
            ->add('courriel', EmailType::class, [
                'required' => true,
                'attr' => ['class' => 'form-input']
            ])
            ->add('numeroTelephone', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'form-input']
            ])
            ->add('sessions')
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'form-btn']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
