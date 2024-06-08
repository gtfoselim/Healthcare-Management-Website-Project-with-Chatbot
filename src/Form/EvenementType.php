<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Sponsor;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageEvenement', FileType::class, array('data_class' => null, 'required' => false))
            ->add('typeEvenement')
            ->add('nomEvenement')
            ->add('lieuEvenement')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('nbParticipants')
            ->add('Color', ColorType::class)
            ->add('Sponsor', EntityType::class, [
                'class' => Sponsor::class,
                'choice_label' => 'nomSponsor',
                'label' => 'Nom Sponsor',
                'placeholder' => 'Choisir un sponsor', // Set the placeholder text
                'required' => false // Set required to false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
