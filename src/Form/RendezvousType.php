<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Rendezvous;
use App\Entity\Medecin;
use App\Repository\MedecinRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezvousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('fullname')
            ->add('email')
            ->add('tel')
            ->add('date')
            ->add('time')
            
            ->add('note')
            
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => 'fullname', // ou un autre champ à afficher
                'query_builder' => function (MedecinRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->andWhere('m.role LIKE :role')
                        ->setParameter('role', '["medecin"]');
                },
            ])
            ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rendezvous::class,
        ]);
    }
}
