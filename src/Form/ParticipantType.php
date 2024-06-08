<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Medecin;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateParticipation', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('description')
            ->add('Evenement', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'nomEvenement',
                'label' => 'Nom Evenement'
            ])
            ->add('Medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => 'email',
                'label' => 'Email'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
