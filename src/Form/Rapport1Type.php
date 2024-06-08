<?php

namespace App\Form;

use App\Entity\Rapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Rapport1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Medical Certificate ' => 'Medical Certificate',
                    'Diagnostic Report' => 'Diagnostic Report',
                    'Laboratory Test Results' => 'Laboratory Test Results',
                    'Autopsy Report' => 'Autopsy Report',
                    'Rehabilitation Plan' => 'Rehabilitation Plan',
                    'Mental Health Assessment ' => 'Mental Health Assessment ',

                ],
            ])
            ->add('note')
            ->add('rendezvous')
            ->add('save',SubmitType::class)
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}
