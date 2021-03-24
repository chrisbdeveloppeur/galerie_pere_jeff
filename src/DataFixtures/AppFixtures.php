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

        for ($i=0; $i < 50; $i++){
            $oeuvre = new Oeuvre();
            $nb = $faker->numberBetween(1,4);
            $oeuvre->setTitre($faker->words($nb, true));
            $oeuvre->setDescription($faker->realText());
            $oeuvre->setFileName($faker->randomElement(['480x600.603e1bf2.png','480x480.ec819a0d.png','480x320.86ac0bc4.png','360x640.17a22b99.png']));
            $annee = $faker->dateTimeBetween('-10 years','now');
            $annee = $annee->format('Y');
            $oeuvre->setAnnee($annee);
            $manager->persist($oeuvre);
        }



        $manager->flush();
    }
}
