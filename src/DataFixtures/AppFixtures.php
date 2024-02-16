<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\House;
use App\Entity\Option;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        /** @var Generator */
        $faker = Factory::create('fr_FR');

        /**Création des options */
        $labels = [
            'PMR', 'jacuzzi', 'baignoire', 'ascenseur', 'parking', 'climatisation', 'piscine', 'terrasse', 'garage'
        ];
        $options = [];
        foreach($labels as $label)
        {
            $option = new Option;
            $option->setName($label);
            $options[] = $option;
        }


        for ($i=0; $i < 50; $i++) 
        { 
            $house = new House;
            $price = random_int(6, 99) * 1000000;
            $house->setName($faker->text(30))
                ->setRooms(random_int(1, 7))
                ->setArea(random_int(20, 350))
                ->setPrice($price)
            ;

            $random = random_int(0, 8);
            $selectOptions = $faker->randomElements($options, $random);
            foreach($selectOptions as $selectOption)
            {
                $house->addOption($selectOption);
            }
            
            $manager->persist($house);
        }


        $manager->flush();
    }
}
