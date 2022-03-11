<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('content', TextareaType::class, [
                'label' => 'Texte',
                'attr' => ['rows' => 10]
            ])
            /*
            ->add('createdAt', DateTimeType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text'
            ])
            */
            // ->add('updatedAt')
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'fullName',
                'label' => 'Auteur'
            ])
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'categoryName',
                'label' => 'Catégorie'
            ])
            ->add('uploadedFile', FileType::class, [
                'label' => 'La photo de l\'article',
                'required' => false,
                //'mapped' => false
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'tagName',
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => 'd-flex flex-wrap']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
