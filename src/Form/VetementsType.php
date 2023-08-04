<?php

namespace App\Form;

use App\Entity\Vetements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class VetementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $ageChoices = [];
            for ($i = 0; $i <= 14; $i += 2) {
                $ageLabel = "De $i à " . ($i + 2) . " ans";
                $ageValue = 'age' . ($i / 2 + 1);
                $ageChoices[$ageLabel] = $ageValue;
            }
            // Créez un tableau pour stocker les choix de taille
            $sizeChoices = [
                'XS' => 'XS',
                'S' => 'S',
                'M' => 'M',
                'L' => 'L',
                'XL' => 'XL',
                'XXL' => 'XXL',
            ];
            // Fusionnez les choix d'âge et de taille en un seul tableau
            $choices = array_merge($ageChoices, $sizeChoices);

        $builder
            ->add('titre')
            ->add('description')
            ->add('sex', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Enfant' => 'Enfant',
                ],
                'placeholder' => 'Choisir sex',
            ])
            ->add('taille', ChoiceType::class, [
                'choices' => $choices,
                'placeholder' => 'Choisir âge ou taille',
            ])

            ->add('categorie')
            ->add('prix');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vetements::class,
        ]);
    }

}
