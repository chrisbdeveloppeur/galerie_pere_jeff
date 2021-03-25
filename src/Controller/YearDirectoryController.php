<?php

namespace App\Controller;

use App\Entity\YearDirectory;
use App\Form\YearDirectoryType;
use App\Repository\YearDirectoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/year/directory")
 */
class YearDirectoryController extends AbstractController
{
    /**
     * @Route("/", name="year_directory_index", methods={"GET"})
     */
    public function index(YearDirectoryRepository $yearDirectoryRepository): Response
    {
        return $this->render('year_directory/index.html.twig', [
            'year_directories' => $yearDirectoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="year_directory_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $yearDirectory = new YearDirectory();
        $form = $this->createForm(YearDirectoryType::class, $yearDirectory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($yearDirectory);
            $entityManager->flush();

            return $this->redirectToRoute('year_directory_index');
        }

        return $this->render('year_directory/new.html.twig', [
            'year_directory' => $yearDirectory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="year_directory_show", methods={"GET"})
     */
    public function show(YearDirectory $yearDirectory): Response
    {
        return $this->render('year_directory/show.html.twig', [
            'year_directory' => $yearDirectory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="year_directory_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, YearDirectory $yearDirectory): Response
    {
        $form = $this->createForm(YearDirectoryType::class, $yearDirectory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('year_directory_index');
        }

        return $this->render('year_directory/edit.html.twig', [
            'year_directory' => $yearDirectory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="year_directory_delete", methods={"POST"})
     */
    public function delete(Request $request, YearDirectory $yearDirectory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$yearDirectory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($yearDirectory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('year_directory_index');
    }
}
