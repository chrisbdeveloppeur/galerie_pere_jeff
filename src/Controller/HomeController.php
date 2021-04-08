<?php

namespace App\Controller;

use App\Entity\Expo;
use App\Entity\TextMenuBurger;
use App\Repository\ExpoRepository;
use App\Repository\OeuvreRepository;
use App\Repository\TextMenuBurgerRepository;
use App\Repository\YearDirectoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $galeries;
    private $textMenuBurger;
    private $expo;
    public function __construct(YearDirectoryRepository $yearDirectoryRepository, TextMenuBurgerRepository $textMenuBurgerRepository, ExpoRepository $expoRepository, EntityManagerInterface $em)
    {
        $this->galeries = $yearDirectoryRepository->classByYear();
        if (empty($textMenuBurgerRepository->findAll())){
            $newTextMenuBurger = new TextMenuBurger();
            $em->persist($newTextMenuBurger);
            $em->flush();
            $this->textMenuBurger = $textMenuBurgerRepository->findOneBy([]);
        }else{
            $this->textMenuBurger = $textMenuBurgerRepository->findOneBy([]);
        }
        if (empty($expoRepository->findAll())){
            $newExpo = new Expo();
            $em->persist($newExpo);
            $em->flush();
            $this->expo = $expoRepository->findOneBy([]);
        }else{
            $this->expo = $expoRepository->findOneBy([]);
        }
    }

//    /**
//     * @Route("/", name="home")
//     */
//    public function index(): Response
//    {
//        return $this->render('home.html.twig', [
//            'galeries' => $this->galeries,
//            'text_menu_burger' => $this->textMenuBurger,
//            'expo' => $this->expo,
//        ]);
//    }

    /**
     * @param OeuvreRepository $oeuvreRepository
     * @return Response
     * @Route("/", name="home")
     */
    public function galeriesAnnees( OeuvreRepository $oeuvreRepository): Response
    {
        $oeuvres = $oeuvreRepository->findTop10();
//        dd($oeuvres);
        return $this->render("home.html.twig", [
            'oeuvres' => $oeuvres,
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }
}
