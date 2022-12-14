<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
                'attr' => ['class' => 'form-input'],
                'widget' => 'single_text'
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
            ->add('sessions', EntityType::class, [
                // Permet d'ignorer le champ lors de l'écriture ou lecture dans l'object.
                'mapped' => false,
                // Indique à quel classe 'session fait référence
                'class' => Session::class,
                // Permet de choisir la valeur de la classe Session que je souhaite afficher (ici 'intitule')
                'choice_label' => 'intitule',
                'required' => false
            ])
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
