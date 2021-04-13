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

        $dir = 'public/images/oeuvres';
        $pics = scandir($dir);
        $pics = array_splice($pics, 2);

        $k = 0;
        for ($i=0; $i < 4; $i++){
            $x = $i*10;
            $year = new YearDirectory();
            $nb = $faker->numberBetween(1,7);
            $nb2 = 250;
            $annee_start = new \DateTime('now -'.($x+10).'Years');
            $annee_end = new \DateTime('now -'.($x+1).'Years');
            $year->setYearStart($annee_start->format('Y'));
            $year->setYearEnd($annee_end->format('Y'));
            $annee = $annee_start->format('Y') . " / ". $annee_end->format('Y');
            $year->setYear($annee);

            for ($j=0; $j < $nb2; $j++){
                $oeuvre = new Oeuvre();
                $k = $k+1;
                $oeuvre->setTopPosition(0);
                $oeuvre->setImgPosition($k);
                $oeuvre->setFileName($faker->randomElement($pics));
                $oeuvre->setYear($faker->numberBetween($annee_start->format('Y'),$annee_end->format('Y')));
                $nb = $faker->numberBetween(1,4);
                $oeuvre->setTitre($faker->words($nb, true));
                $oeuvre->setDescription('- taille : <br>- type : <br>- matière : ');
                $manager->persist($oeuvre);
                $year->addOeuvre($oeuvre);
            }

            $manager->persist($year);
        }



        $manager->flush();
    }
}
