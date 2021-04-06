<?php

namespace App\Controller;

use App\Entity\GroupeGaleries;
use App\Entity\TextMenuBurger;
use App\Form\GroupeGaleriesType;
use App\Repository\GroupeGaleriesRepository;
use App\Repository\TextMenuBurgerRepository;
use App\Repository\YearDirectoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/groupe/galeries")
 */
class GroupeGaleriesController extends AbstractController
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
     * @Route("/", name="groupe_galeries_index", methods={"GET"})
     */
    public function index(GroupeGaleriesRepository $groupeGaleriesRepository): Response
    {
        return $this->render('groupe_galeries/index.html.twig', [
            'groupe_galeries' => $groupeGaleriesRepository->findAll(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }

    /**
     * @Route("/new", name="groupe_galeries_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $groupeGalery = new GroupeGaleries();
        $form = $this->createForm(GroupeGaleriesType::class, $groupeGalery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupeGalery->setTitle($groupeGalery->getYearStart() ." à ". $groupeGalery->getYearEnd());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupeGalery);
            $entityManager->flush();

            return $this->redirectToRoute('groupe_galeries_index');
        }

        return $this->render('groupe_galeries/new.html.twig', [
            'groupe_galery' => $groupeGalery,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }

    /**
     * @Route("/{id}", name="groupe_galeries_show", methods={"GET"})
     */
    public function show(GroupeGaleries $groupeGalery): Response
    {
        return $this->render('groupe_galeries/show.html.twig', [
            'groupe_galery' => $groupeGalery,
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="groupe_galeries_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GroupeGaleries $groupeGalery): Response
    {
        $form = $this->createForm(GroupeGaleriesType::class, $groupeGalery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupeGalery->setTitle($groupeGalery->getYearStart() ." à ". $groupeGalery->getYearEnd());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('groupe_galeries_index');
        }

        return $this->render('groupe_galeries/edit.html.twig', [
            'groupe_galery' => $groupeGalery,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }

    /**
     * @Route("/{id}", name="groupe_galeries_delete", methods={"POST"})
     */
    public function delete(Request $request, GroupeGaleries $groupeGalery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupeGalery->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($groupeGalery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('groupe_galeries_index');
    }
}
