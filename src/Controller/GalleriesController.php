<?php

namespace App\Controller;

use App\Repository\OeuvreRepository;
use \App\Entity\YearDirectory;
use App\Repository\YearDirectoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/galerie", name="gallery_")
 */
class GalleriesController extends AbstractController
{
    /**
     * @Route("/{year}", name="year")
     */
    public function galeriesAnnees($year, YearDirectoryRepository $yearDirectoryRepository): Response
    {
        $galerie = $yearDirectoryRepository->findOneBy(['year' => $year]);
        $galeries = $yearDirectoryRepository->classByYear();
        $oeuvres = $galerie->getOeuvres();
        return $this->render('galleries/gallery.html.twig', [
            'oeuvres' => $oeuvres,
            'year' => $year,
            'galerie' => $galerie,
            'galeries' => $galeries,
        ]);
    }
}
