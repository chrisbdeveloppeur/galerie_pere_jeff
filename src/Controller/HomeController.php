<?php

namespace App\Controller;

use App\Repository\OeuvreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(OeuvreRepository $repository): Response
    {
        $oeuvres = $repository->findAll();
        return $this->render('home.html.twig', [
            'oeuvres' => $oeuvres,
        ]);
    }
}
