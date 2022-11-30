<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('programmes', CollectionType::class)
            ->add('stagiaires', CollectionType::class)
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
