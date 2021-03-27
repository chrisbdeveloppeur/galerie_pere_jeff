<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Form\OeuvreType;
use App\Repository\OeuvreRepository;
use App\Repository\YearDirectoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/oeuvre")
 * @IsGranted("ROLE_ADMIN")
 */
class OeuvreController extends AbstractController
{
    /**
     * @Route("/", name="oeuvre_index", methods={"GET"})
     */
    public function index(OeuvreRepository $oeuvreRepository, YearDirectoryRepository $yearDirectoryRepository): Response
    {
        $galeries = $yearDirectoryRepository->classByYear();
        return $this->render('oeuvre/index.html.twig', [
            'oeuvres' => $oeuvreRepository->classByAnnee(),
            'galeries' => $galeries,
        ]);
    }

    /**
     * @Route("/new", name="oeuvre_new", methods={"GET","POST"})
     */
    public function new(Request $request, YearDirectoryRepository $yearDirectoryRepository): Response
    {
        $galeries = $yearDirectoryRepository->classByYear();
        $oeuvre = new Oeuvre();
        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oeuvre);
            $entityManager->flush();
            $msg = 'L\'oeuvre à bien été ajoutée';
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('oeuvre_index');
        }

        return $this->render('oeuvre/new.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form->createView(),
            'galeries' => $galeries,
        ]);
    }

    /**
     * @Route("/{id}", name="oeuvre_show", methods={"GET"})
     */
    public function show(Oeuvre $oeuvre, YearDirectoryRepository $yearDirectoryRepository): Response
    {
        $galeries = $yearDirectoryRepository->classByYear();
        return $this->render('oeuvre/show.html.twig', [
            'oeuvre' => $oeuvre,
            'galeries' => $galeries,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="oeuvre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Oeuvre $oeuvre, YearDirectoryRepository $yearDirectoryRepository): Response
    {
        $galeries = $yearDirectoryRepository->classByYear();
        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $msg = 'L\'oeuvre à bien été modifiée';
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('oeuvre_index');
        }

        return $this->render('oeuvre/edit.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form->createView(),
            'galeries' => $galeries,
        ]);
    }

    /**
     * @Route("/{id}", name="oeuvre_delete", methods={"POST"})
     */
    public function delete(Request $request, Oeuvre $oeuvre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oeuvre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($oeuvre);
            $entityManager->flush();
        }
        $msg = 'L\'oeuvre à été supprimée';
        $this->addFlash('warning', $msg);
        return $this->redirectToRoute('oeuvre_index');
    }
}
