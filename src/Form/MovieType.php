<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Par ex. Harry Potter'
                ]
            ])
            ->add('releaseDate', DateType::class, [
                'widget' => 'choice',
                'years' => range(date('Y') - 100, date('Y') + 10),
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée en minutes'
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Film ou série ?',
                'choices' => [
                    'Film' => 'Film',
                    'Série' => 'Série'
                ],
                'placeholder' => 'Votre choix...'
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Résumé',
                'attr' => [
                    'rows' => 3,
                ],
                'help' => '200 caractères max.'
            ])
            ->add('synopsis', TextareaType::class, [
                'label' => 'Synopsis',
                'attr' => [
                    'rows' => 3,
                ],
                'help' => '5000 caractères max.'
            ])
            ->add('poster', UrlType::class, [
                'label' => 'Affiche',
                'help' => 'Une URL en http:// ou https://',
                'default_protocol' => 'https'
            ])
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'multiple' => true,
                // Sous forme de checkboxes
                'expanded' => true,
                // Pour trier les genres dans l'ordre alphabétique on va faire une requête personnalisé avec ... le queryBuilder (Dql)
                'query_builder' => function (EntityRepository $er) {
                    // retourne la requete
                    return $er->createQueryBuilder('g')
                    ->orderBy('g.name', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
