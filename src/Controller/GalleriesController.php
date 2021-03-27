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
     * @Route("/{id_gallery}", name="year")
     */
    public function galeriesAnnees($id_gallery, YearDirectoryRepository $yearDirectoryRepository): Response
    {
        $galerie = $yearDirectoryRepository->find($id_gallery);
        $galeries = $yearDirectoryRepository->classByYear();
        $oeuvres = $galerie->getOeuvres();
        return $this->render('galleries/gallery.html.twig', [
            'oeuvres' => $oeuvres,
            'id_gallery' => $id_gallery,
            'galerie' => $galerie,
            'galeries' => $galeries,
        ]);
    }
}
