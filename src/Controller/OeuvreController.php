<?php

namespace App\Controller;

use App\Entity\Expo;
use App\Entity\Oeuvre;
use App\Entity\TextMenuBurger;
use App\Form\OeuvreType;
use App\Repository\ExpoRepository;
use App\Repository\OeuvreRepository;
use App\Repository\TextMenuBurgerRepository;
use App\Repository\YearDirectoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/", name="oeuvre_index", methods={"GET"})
     */
    public function index(OeuvreRepository $oeuvreRepository, YearDirectoryRepository $yearDirectoryRepository): Response
    {
        return $this->render('oeuvre/index.html.twig', [
            'all_galeries' => $yearDirectoryRepository->findAll(),
            'oeuvres' => $oeuvreRepository->classByAnnee(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }

    /**
     * @Route("/new", name="oeuvre_new", methods={"GET","POST"})
     */
    public function new(Request $request, OeuvreRepository $oeuvreRepository): Response
    {
        $oeuvre = new Oeuvre();
        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);
        $nb_oeuvre = count($oeuvreRepository->findAll()) + 1;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $oeuvre->setImgPosition($nb_oeuvre);
            $entityManager->persist($oeuvre);
            $entityManager->flush();
            $msg = 'L\'oeuvre à bien été ajoutée';
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('oeuvre_index');
        }

        return $this->render('oeuvre/new.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }

    /**
     * @Route("/{id}", name="oeuvre_show", methods={"GET"})
     */
    public function show(Oeuvre $oeuvre): Response
    {
        return $this->render('oeuvre/show.html.twig', [
            'oeuvre' => $oeuvre,
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="oeuvre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Oeuvre $oeuvre): Response
    {
        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $msg = 'L\'oeuvre <b>' . $oeuvre->getId() . '</b> à bien été modifiée';
            $this->addFlash('success', $msg);
                return $this->redirectToRoute('oeuvre_index');
        }

        return $this->render('oeuvre/edit.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }

    /**
     * @Route("/{id}", name="oeuvre_delete", methods={"POST"})
     */
    public function delete(Request $request, Oeuvre $oeuvre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oeuvre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            if ($oeuvre->getTitre() != null){
                $oeuvreName = $oeuvre->getTitre();
            }else{
                $oeuvreName = $oeuvre->getId();
            }
            $entityManager->remove($oeuvre);
            $entityManager->flush();
        }
        $msg = 'L\'oeuvre <b>' . $oeuvreName . '</b> à été supprimée';
        $this->addFlash('warning', $msg);
        return $this->redirectToRoute('oeuvre_index');
    }
}
