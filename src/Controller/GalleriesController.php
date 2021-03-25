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
    public function galeriesAnnees(OeuvreRepository $repository, $year, YearDirectoryRepository $yearDirectoryRepository): Response
    {
//        $oeuvres = $repository->findByYear($year);
        $galeries = $yearDirectoryRepository->findOneBy(['year' => $year]);
        $oeuvres = $galeries->getOeuvres();
//        dd($galeries->getOeuvres());
        return $this->render('galleries/gallery.html.twig', [
            'oeuvres' => $oeuvres,
            'year' => $year,
        ]);
    }
}
