<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\YearDirectory;
use App\Repository\OeuvreRepository;
use App\Repository\YearDirectoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(OeuvreRepository $repository, YearDirectoryRepository $yearDirectoryRepository, EntityManagerInterface $em): Response
    {
        $galeries = $yearDirectoryRepository->classByYear();
        return $this->render('home.html.twig', [
            'galeries' => $galeries,
        ]);
    }
}
