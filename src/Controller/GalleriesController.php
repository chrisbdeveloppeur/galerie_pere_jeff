<?php

namespace App\Controller;

use App\Entity\TextMenuBurger;
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
     * @Route("/{id_gallery}", name="year")
     */
    public function galeriesAnnees($id_gallery, YearDirectoryRepository $yearDirectoryRepository): Response
    {
        $galerie = $yearDirectoryRepository->find($id_gallery);
        $oeuvres = $galerie->getOeuvres();
        return $this->render('galleries/gallery.html.twig', [
            'oeuvres' => $oeuvres,
            'id_gallery' => $id_gallery,
            'galerie' => $galerie,
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }
}
