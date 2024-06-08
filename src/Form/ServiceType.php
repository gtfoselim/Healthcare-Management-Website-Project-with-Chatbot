<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Doctrine\ORM\Mapping\Entity;
use App\Entity\Service;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('image', FileType::class, [
                'label' => 'service Picture',
                'mapped' => false,
                'required' => false, // Set to true if the photo is mandatory
                // Add any other options you need, such as validation constraints
            ])
            ->add('description',TextareaType::class)
            ->add('date_cr')
            ->add('id_categorie' , EntityType::class,['class' =>Category::class,
            'choice_label' =>'nom',
            'label'=>'nom',

            ])
           /* ->add('active', ChoiceType::class, [
                'label' => 'Active',
                'choices' => [
                    'Non' => false,
                    'Oui' => true,
                ],
                'expanded' => true, // This makes the switch-like appearance
                'multiple' => false, // Set to false to render a single switch
                
            ])*/
            ->add('active', CheckboxType::class, [
                'label_attr' => [
                    'active' => 'checkbox-switch ',
                ],
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'homepage',
               
            ])
            ->add('save',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
