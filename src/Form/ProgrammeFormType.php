<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Programme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProgrammeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modules', EntityType::class, [
                // Permet d'ignorer le champ lors de la lecture ou écriture dans l'object.
                'mapped' => false,
                // Indique à quel classe 'modules' fait référence.
                'class' => Module::class,
                // Choisis le label que je souhaite afficher de module (ici son intitulé).
                'choice_label' => 'intitule',
            ])
            // Cache le champs
            ->add('sessions', HiddenType::class, [
                'mapped' => false
            ])
            ->add('nbJour', IntegerType::class, [
                'label' => 'Durée en jours',
                'attr' => ['min' => 1, 'max' => 100]
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
