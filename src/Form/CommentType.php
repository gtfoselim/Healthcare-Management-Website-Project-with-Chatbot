<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_comment',TextType::class,['data'=>mt_rand(10000,999999),])
            ->add('contenu_comment', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control mb-4','placeholder'=>'Comment','rows'=>'12'
                ]
            ])
            ->add('likes_comment')
            ->add('dislikes_comment')
            ->add('name_comment', TextType::class, [
                'attr' => [
                    'class' => 'form-control','placeholder'=>'Name'
                ]
            ])
            ->add('mail_comment', TextType::class, [
                'attr' => [
                    'class' => 'form-control','placeholder'=>'Email'
                ]
            ])
            
            ->add('datecreation_comment', DateTimeType::class, [
                'label' => 'Date',
                // Set default value to today's date
                'data' => new \DateTime('now'), 
                // You can customize the date input format as per your requirement
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('id_post', EntityType::class, [
                'class' => Post::class,
                'choice_label' => 'id',
                'label' => 'id_post',
            ])
            ->add("captcha",ReCaptchaType::class)
            ->add('SubmitComment', SubmitType::class,[
                'attr'=>['class'=>'btn btn-main-2 btn-round-full','placeholder'=>'Submit Comment','label'=>'subb',]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
