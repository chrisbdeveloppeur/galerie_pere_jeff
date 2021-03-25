<?php

namespace App\Controller;

use App\Entity\YearDirectory;
use App\Repository\OeuvreRepository;
use App\Repository\YearDirectoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(OeuvreRepository $repository, YearDirectoryRepository $yearDirectoryRepository, EntityManagerInterface $em): Response
    {
        $allOeuvres = $repository->findAll();
        $oeuvres = $repository->groupedByAnnee();

        $years = [];
        for($i=0; $i<count($oeuvres); $i++){
            $yearDirectory = new YearDirectory();
            $yearDirectory->setTitle('Galerie ' . $i);
            $annee = $oeuvres[$i]->getAnnee();
            $yearDirectory->setYear($annee);
            foreach ($allOeuvres as $o){
                if ($o->getAnnee() == $annee ){
                    $yearDirectory->addOeuvre($o);
                }
            }
            $years[] = $yearDirectory;
        }

//        $years = $yearDirectoryRepository->findAll();
        return $this->render('home.html.twig', [
            'oeuvres' => $oeuvres,
            'years' => $years,
        ]);
    }
}
