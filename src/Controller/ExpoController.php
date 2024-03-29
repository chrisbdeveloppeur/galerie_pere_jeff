<?php

namespace App\Controller;

use App\Entity\Expo;
use App\Entity\TextMenuBurger;
use App\Form\ExpoType;
use App\Repository\ExpoRepository;
use App\Repository\TextMenuBurgerRepository;
use App\Repository\YearDirectoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/expo")
 */
class ExpoController extends AbstractController
{

    private $galeries;
    private $textMenuBurger;
    private $expo;
    public function __construct(YearDirectoryRepository $yearDirectoryRepository, TextMenuBurgerRepository $textMenuBurgerRepository, ExpoRepository $expoRepository, EntityManagerInterface $em)
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
        if (empty($expoRepository->findAll())){
            $newExpo = new Expo();
            $em->persist($newExpo);
            $em->flush();
            $this->expo = $expoRepository->findOneBy([]);
        }else{
            $this->expo = $expoRepository->findOneBy([]);
        }
    }

    /**
     * @Route("/", name="expo_index", methods={"GET"})
     */
    public function index(ExpoRepository $expoRepository): Response
    {
        return $this->render('expo/index.html.twig', [
            'expos' => $expoRepository->findAll(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }

    /**
     * @Route("/new", name="expo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $expo = new Expo();
        $form = $this->createForm(ExpoType::class, $expo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($expo);
            $entityManager->flush();
            $msg = 'La rubrique exposition à bien étée crée';
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('expo_index');
        }

        return $this->render('expo/new.html.twig', [
            'expo' => $expo,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }

    /**
     * @Route("/{id}", name="expo_show", methods={"GET"})
     */
    public function show(Expo $expo): Response
    {
        return $this->render('expo/show.html.twig', [
            'expo' => $expo,
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="expo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Expo $expo): Response
    {
        $form = $this->createForm(ExpoType::class, $expo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $msg = 'La rubrique exposition à bien étée modifiée';
            $this->addFlash('success', $msg);
//            return $this->redirectToRoute('expo_index');
        }

        return $this->render('expo/edit.html.twig', [
            'expo' => $expo,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }

    /**
     * @Route("/{id}", name="expo_delete", methods={"POST"})
     */
    public function delete(Request $request, Expo $expo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($expo);
            $entityManager->flush();
            $msg = 'La rubrique exposition à bien étée suprimée';
            $this->addFlash('success', $msg);
        }

        return $this->redirectToRoute('expo_index');
    }
}
