<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_post',TextType::class,['data'=>mt_rand(10000,999999),])
            ->add('type_post', ChoiceType::class, [
                'label' => 'Choose Type',
                'choices' => [
                    'Medicine ' => 'Medicine',
                    'Equipments' => 'Equipments',
                    'Heart' => 'Heart',
                    'Free counselling' => 'Free counselling',
                    'Lab test' => 'Lab test',
                    // Add more options as needed
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('title_post', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control','placeholder'=>'Post Title','rows'=>'3'
                ]
            ])
            ->add('contenu_post', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control','placeholder'=>'Post','rows'=>'12'
                ]
            ])
            ->add('nb_comments_post')
            ->add('validation_post')
            ->add('makedate_post', DateTimeType::class, [
                'label' => 'Date',
                // Set default value to today's date
                'data' => new \DateTime('now'), 
                // You can customize the date input format as per your requirement
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('likes_post')
            ->add('dislikes_post')
            ->add('SUBMITPOST', SubmitType::class,[
                'attr'=>['class'=>'btn btn-main btn-round-full','placeholder'=>'SUBMIT POST','label'=>'subb',]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
