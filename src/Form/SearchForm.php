<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Vetements;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('categorie', ChoiceType::class, [
                'choices' => array_combine($options['categories'], $options['categories']),
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('sex', ChoiceType::class, [
                'choices' => array_combine($options['sex'], $options['sex']),
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('taille', ChoiceType::class, [
                'choices' => array_combine($options['taille'], $options['taille']),
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('prixMin', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix min'
                ]
            ])
            ->add('prixMax', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix max'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
            'categories' => [],
            'sex' => [],
            'taille' => [],
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}