<?php

namespace App\DataFixtures;

use App\Entity\Oeuvre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < 10; $i++){
            $oeuvre = new Oeuvre();
            $nb = $faker->numberBetween(1,4);
            $oeuvre->setTitre($faker->words($nb, true));
            $oeuvre->setDescription($faker->realText());
            $manager->persist($oeuvre);
        }



        $manager->flush();
    }
}
