<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrez le nom',
                ],
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Catégorie',
                'required' => false,
                'choices' => [
                    'Technique' => 'Technique',
                    'Design/UI' => 'Design/UI',
                    'Contenu' => 'Contenu',
                    'Sécurité' => 'Sécurité',
                    'Communication/Support' => 'Communication/Support',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('submissionDate', DateType::class, [
                'label' => 'Date de soumission',
                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Sélectionnez la date',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Set default options here if needed
        ]);
    }
}
