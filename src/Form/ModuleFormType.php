<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Categorie;
use App\Entity\Programme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModuleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextType::class, [
                'required' => true,
                'attr' => ['class' => 'form-input']
            ])
            ->add('categorie', EntityType::class, [
                // Permet d'ignorer la lecture ou l'écriture dans l'object
                'mapped' => false,
                // Fait référence à la classe Categorie
                'class' => Categorie::class,
                // Fait référence à la valeur que je souhaite afficher (ici -> intitule)
                'choice_label' => 'intitule'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'form-btn']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
