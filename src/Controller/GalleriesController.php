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

/**
 * @Route("/galerie", name="gallery_")
 */
class GalleriesController extends AbstractController
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

    /**
     * @Route("/{id_gallery}", name="year")
     */
    public function galeriesAnnees($id_gallery, YearDirectoryRepository $yearDirectoryRepository, OeuvreRepository $oeuvreRepository): Response
    {
        $galerie = $yearDirectoryRepository->find($id_gallery);
        $oeuvres = $oeuvreRepository->findByGalery($galerie->getId());
        return $this->render('galleries/gallery.html.twig', [
            'oeuvres' => $oeuvres,
            'id_gallery' => $id_gallery,
            'galerie' => $galerie,
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }
}
