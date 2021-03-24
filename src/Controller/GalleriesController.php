<?php

namespace App\Controller;

use App\Repository\OeuvreRepository;
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
    public function galeriesAnnees(OeuvreRepository $repository, $year): Response
    {
        $oeuvres = $repository->findByYear($year);
        return $this->render('galleries/years.html.twig', [
            'oeuvres' => $oeuvres,
            'year' => $year,
        ]);
    }
}
