<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Oeuvre;
use App\Entity\YearDirectory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $admin = new Admin();
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $password = '123456';
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, $password));
        $manager->persist($admin);

        $k = 0;
        for ($i=0; $i < 10; $i++){
            $x = $i*10;
            $year = new YearDirectory();
            $nb = $faker->numberBetween(1,7);
            $nb2 = $faker->numberBetween(5,20);
//            $year->setTitle($faker->words($nb, true));
            $annee_start = new \DateTime('now -'.($x+1).'Years');
            $year->setYearEnd($annee_start->format('Y'));
            $annee_end = new \DateTime('now -'.($x+10).'Years');
            $year->setYearStart($annee_end->format('Y'));
            $annee = $annee_start->format('Y') . " / ". $annee_end->format('Y');
            $year->setYear($annee);

            for ($j=0; $j < $nb2; $j++){
                $oeuvre = new Oeuvre();
                $k = $k+1;
                $oeuvre->setImgPosition($k);
                $oeuvre->setYear($faker->numberBetween($annee_start->format('Y'),$annee_end->format('Y')));
                $nb = $faker->numberBetween(1,4);
                $oeuvre->setTitre($faker->words($nb, true));
                $oeuvre->setDescription($faker->realText());
//                $oeuvre->setFileName($faker->randomElement(['480x600.603e1bf2.png','480x480.ec819a0d.png','480x320.86ac0bc4.png','360x640.17a22b99.png']));
//                $annee = $faker->dateTimeBetween('-10 years','now');
//                $annee = $annee->format('Y');
                $manager->persist($oeuvre);
                $year->addOeuvre($oeuvre);
            }

            $manager->persist($year);
        }

//        for ($i=0; $i < 50; $i++){
//            $oeuvre = new Oeuvre();
//            $nb = $faker->numberBetween(1,4);
//            $oeuvre->setTitre($faker->words($nb, true));
//            $oeuvre->setDescription($faker->realText());
//            $oeuvre->setFileName($faker->randomElement(['480x600.603e1bf2.png','480x480.ec819a0d.png','480x320.86ac0bc4.png','360x640.17a22b99.png']));
//            $annee = $faker->dateTimeBetween('-10 years','now');
//            $annee = $annee->format('Y');
//            $oeuvre->setAnnee($annee);
//            $manager->persist($oeuvre);
//        }



        $manager->flush();
    }
}
