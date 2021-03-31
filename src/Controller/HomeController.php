<?php

namespace App\Controller;

use App\Entity\TextMenuBurger;
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
    public function __construct(YearDirectoryRepository $yearDirectoryRepository, TextMenuBurgerRepository $textMenuBurgerRepository, EntityManagerInterface $em)
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
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }
}
