<?php

namespace App\DataFixtures;

use App\Entity\Vetements;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VetementsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $ageChoices = [];
        for ($i = 0; $i <= 14; $i += 2) {
            $ageLabel = "De $i à " . ($i + 2) . " ans";
            $ageValue = 'age' . ($i / 2 + 1);
            $ageChoices[$ageLabel] = $ageValue;
        }

        $sizeChoices = [
            'XS' => 'XS',
            'S' => 'S',
            'M' => 'M',
            'L' => 'L',
            'XL' => 'XL',
            'XXL' => 'XXL',
        ];

        // Générer des valeurs aléatoires pour les tranches d'âge et les tailles
        $randomAgeIndex = $faker->numberBetween(0, count($ageChoices) - 1);
        $randomSizeIndex = $faker->numberBetween(0, count($sizeChoices) - 1);

        $randomAge = array_values($ageChoices)[$randomAgeIndex];
        $randomSize = array_values($sizeChoices)[$randomSizeIndex];

        // Fusionner les choix d'âge et de taille en un seul tableau
        $choices = array_merge($ageChoices, $sizeChoices);

        for ($i = 0; $i < 100; $i++) {
            $vetements = new Vetements();
            $vetements
                ->setTitre($faker->words(3, true))
                ->setDescription($faker->sentences(3,true))
                ->setSex($faker->randomElement(['Homme', 'Femme', 'Enfant']))
                ->setTaille($faker->randomElement($choices))
                ->setCategorie($faker->randomElement(['Jupe', 'Pantalon', 'Pull', 'T-shirt', 'Chemise', 'Lingerie', 'Sport']))
                ->setPrix($faker->numberBetween(10, 500));
            $manager->persist($vetements);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
