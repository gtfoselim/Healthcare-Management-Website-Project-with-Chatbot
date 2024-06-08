<?php

namespace App\Form;

use App\Entity\Rapport;
use App\Entity\Rendezvous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\RendezvousRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RapportType extends AbstractType
{
    private $rendezvousRepository;

    public function __construct(RendezvousRepository $rendezvousRepository)
    {
        $this->rendezvousRepository = $rendezvousRepository;
    }
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
            ->add('rendezvous', EntityType::class, [
                'class' => Rendezvous::class,
                'choices' => $this->rendezvousRepository->findRendezvousSansRapport(),
                // ... autres options ...
            ])
            ->add('note')
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
