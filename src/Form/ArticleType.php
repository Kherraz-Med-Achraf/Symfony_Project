<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'attr' => [
                    'placeholder' => "Ajouter un titre à l'article"
                ]
            ])
            ->add('contenu')
            ->add('dateCreation', null , [
                'widget' => 'single_text'
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' =>true,
                'by_reference' => false  // pour permettre de lier les categorie et les article
            ])
            ->add('brouillon', SubmitType::class, [
                'label' => 'Enregistrer en brouillon'
            ])
            ->add('publier' , SubmitType::class, [
                'label' => 'Publier'
            ])
            //pas besoit de dire 'mapped' = 'false' pour faire comprendre qui fait pas partir de
            //notre entitée car symfony sais qu'un champs SubmitType ne fait pas partie de la class
            //article
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
