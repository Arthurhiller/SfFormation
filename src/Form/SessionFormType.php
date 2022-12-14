<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\ProgrammeFormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SessionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextType::class, [
                'required' => true
            ])
            ->add('dateDebut', DateType::class, [
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('dateFin', DateType::class, [
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('nbPlace', IntegerType::class, [
                'required' => true
            ])
            ->add('detailProgramme', TextareaType::class, [
                'required' => true
            ])
            ->add('programmes', CollectionType::class, [
                // La collection attend l'élément qu'elle entrera dans le form
                // Ce n'est pas obligatoire que ce soit un autre form
                'entry_type' => ProgrammeFormType::class,
                'prototype' => true,
                // autorisr l'ajout de nouveau élément dans Session qui seront persister grace au cascade_persist sur l'élément
                // cela va activer un data prototype qui sera un attribut html qu'on pourra manipuler en js
                'allow_add' => true,
                'allow_delete' => true,
                // Il est obligatoire car Session n'a pas de setProgrammes -> c'est Stagiaire qui le contient
                
                'by_reference' => false
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
