<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('content', TextareaType::class)
            ->add('rating', ChoiceType::class, [
                'choices' => [
                    'Excellent' => 'Excellent',
                    'Très bon' => 'Très bon',
                    'Bon' => 'Bon',
                    'Peut mieux faire' => 'Peut mieux faire',
                    'À éviter' => 'À éviter',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('reactions', ChoiceType::class, [
                'choices' => [
                    'Rire' => 'Rire',
                    'Pleurer' => 'Pleurer',
                    'Réfléchir' => 'Réfléchir',
                    'Dormir' => 'Dormir',
                    'Rêver' => 'Rêver',
                ],
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('watchedAt', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
            ])
            ->add('movie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
