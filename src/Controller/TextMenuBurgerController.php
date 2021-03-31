<?php

namespace App\Controller;

use App\Entity\TextMenuBurger;
use App\Form\TextMenuBurgerType;
use App\Repository\TextMenuBurgerRepository;
use App\Repository\YearDirectoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/text/menu/burger")
 */
class TextMenuBurgerController extends AbstractController
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
     * @Route("/", name="text_menu_burger_index", methods={"GET"})
     */
    public function index(TextMenuBurgerRepository $textMenuBurgerRepository): Response
    {
        return $this->render('text_menu_burger/index.html.twig', [
            'text_menu_burger' => $this->textMenuBurger,
            'galeries' => $this->galeries,
        ]);
    }

    /**
     * @Route("/new", name="text_menu_burger_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $textMenuBurger = new TextMenuBurger();
        $form = $this->createForm(TextMenuBurgerType::class, $textMenuBurger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($textMenuBurger);
            $entityManager->flush();

            return $this->redirectToRoute('text_menu_burger_index');
        }

        return $this->render('text_menu_burger/new.html.twig', [
            'text_menu_burger' => $textMenuBurger,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
        ]);
    }

    /**
     * @Route("/{id}", name="text_menu_burger_show", methods={"GET"})
     */
    public function show(TextMenuBurger $textMenuBurger): Response
    {
        return $this->render('text_menu_burger/show.html.twig', [
            'text_menu_burger' => $textMenuBurger,
            'galeries' => $this->galeries,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="text_menu_burger_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TextMenuBurger $textMenuBurger): Response
    {
        $form = $this->createForm(TextMenuBurgerType::class, $textMenuBurger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('text_menu_burger/edit.html.twig', [
            'text_menu_burger' => $textMenuBurger,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
        ]);
    }

    /**
     * @Route("/{id}", name="text_menu_burger_delete", methods={"POST"})
     */
    public function delete(Request $request, TextMenuBurger $textMenuBurger): Response
    {
        if ($this->isCsrfTokenValid('delete'.$textMenuBurger->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($textMenuBurger);
            $entityManager->flush();
        }

        return $this->redirectToRoute('text_menu_burger_index');
    }
}
