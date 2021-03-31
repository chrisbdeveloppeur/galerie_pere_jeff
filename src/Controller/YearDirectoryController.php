<?php

namespace App\Controller;

use App\Entity\TextMenuBurger;
use App\Entity\YearDirectory;
use App\Form\YearDirectoryType;
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
 * @Route("/year/directory")
 * @IsGranted("ROLE_ADMIN")
 */
class YearDirectoryController extends AbstractController
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
     * @Route("/", name="year_directory_index", methods={"GET"})
     */
    public function index(YearDirectoryRepository $yearDirectoryRepository): Response
    {
        return $this->render('year_directory/index.html.twig', [
            'year_directories' => $yearDirectoryRepository->findAll(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }

    /**
     * @Route("/new", name="year_directory_new", methods={"GET","POST"})
     */
    public function new(Request $request, OeuvreRepository $oeuvreRepository): Response
    {
        $oeuvres = $oeuvreRepository->findAll();
        $yearDirectory = new YearDirectory();
        $form = $this->createForm(YearDirectoryType::class, $yearDirectory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($yearDirectory);
            $entityManager->flush();
            $msg = 'La galerie à bien été créée';
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('year_directory_index');
        }

        return $this->render('year_directory/new.html.twig', [
            'year_directory' => $yearDirectory,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'oeuvres' => $oeuvres,
        ]);
    }

    /**
     * @Route("/{id}", name="year_directory_show", methods={"GET"})
     */
    public function show(YearDirectory $yearDirectory): Response
    {
        return $this->render('year_directory/show.html.twig', [
            'year_directory' => $yearDirectory,
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="year_directory_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, YearDirectory $yearDirectory, OeuvreRepository $oeuvreRepository): Response
    {
        $oeuvres = $oeuvreRepository->findAll();
        $form = $this->createForm(YearDirectoryType::class, $yearDirectory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $msg = 'La galerie à bien été modifiée';
            $this->addFlash('success', $msg);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('year_directory/edit.html.twig', [
            'year_directory' => $yearDirectory,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'oeuvres' => $oeuvres,
        ]);
    }

    /**
     * @Route("/{id_gallery}/add-{id_oeuvre}", name="year_directory_add_oeuvre")
     */
    public function addOeuvreInGallery(YearDirectoryRepository $yearDirectoryRepository,OeuvreRepository $oeuvreRepository, $id_gallery, $id_oeuvre, EntityManagerInterface $em): Response
    {
        $oeuvre = $oeuvreRepository->find($id_oeuvre);
        $gallery = $yearDirectoryRepository->find($id_gallery);

        if ($gallery->getOeuvres()->contains($oeuvre)){
            $gallery->removeOeuvre($oeuvre);
            $msg = 'L\'oeuvre <b>' . $oeuvre->getTitre() . '</b> à été retirée de cette galerie';
            $type = 'warning';
        }else{
            $gallery->addOeuvre($oeuvre);
            $msg = 'L\'oeuvre <b>' . $oeuvre->getTitre() . '</b> à été ajoutée à cette galerie';
            $type = 'info';
        }
        $em->persist($gallery);
        $em->flush();

        return $this->json([
            'id' => $id_gallery,
            'flash_message' => $msg,
            'type' => $type,
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
        $msg = 'La galerie à bien été supprimée';
        $this->addFlash('warning', $msg);
        return $this->redirectToRoute('year_directory_index');
    }

    /**
     * @Route("/{id}/del-img", name="year_directory_delete_img")
     */
    public function deleteImg(YearDirectory $yearDirectory, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $yearDirectory->setFileName(null);
        $entityManager->persist($yearDirectory);
        $entityManager->flush();
        $msg = 'L\'image de couverture de la galerie à bien été supprimée';
        $this->addFlash('warning', $msg);
        return $this->redirectToRoute('year_directory_edit',[
            'id' => $id,
        ]);
    }
}
