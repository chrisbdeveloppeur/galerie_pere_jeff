<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Expo;
use App\Entity\TextMenuBurger;
use App\Form\AdminType;
use App\Form\SendRegisterFormType;
use App\Notif\NotifMessage;
use App\Repository\AdminRepository;
use App\Repository\ExpoRepository;
use App\Repository\TextMenuBurgerRepository;
use App\Repository\YearDirectoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
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
     * @Route("/", name="admin_index", methods={"GET", "POST"})
     */
    public function index(AdminRepository $adminRepository, Request $request, NotifMessage $notifMessage): Response
    {
        $form =  $this->createForm(SendRegisterFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $email = $form->get('email')->getData();
            $token = bin2hex(random_bytes(16));
            $notifMessage->sendRegisterLink($email, $token);
            $message = 'Le formulaire d\'enregistrement vient d\'être envoyer à l\'adresse mail : '. $form->get('email')->getData();
            $this->addFlash('success', $message);
        }

        if ($this->isGranted('ROLE_SUPER_ADMIN')){
            return $this->render('admin/index.html.twig', [
                'form' => $form->createView(),
                'admins' => $adminRepository->findAll(),
                'galeries' => $this->galeries,
                'text_menu_burger' => $this->textMenuBurger,
                'expo' => $this->expo,
            ]);
        }else{
            return $this->redirectToRoute('home');
        }

    }

    /**
     * @Route("/new", name="admin_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admin->setPassword(
              $passwordEncoder->encodePassword(
                  $admin,
                  $form->get('password')->getData()
              )
            );
            $admin->setRoles(['ROLE_ADMIN']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            $message = 'Le compte administrateur '. $admin->getEmail() . ' a bien été crée';
            $this->addFlash('success', $message);
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_show", methods={"GET"})
     */
    public function show(Admin $admin): Response
    {
        return $this->render('admin/show.html.twig', [
            'admin' => $admin,
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Admin $admin): Response
    {
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $message = 'Les modification de votre compte ont bien étées prises en compte';
            $this->addFlash('success', $message);
        }

        return $this->render('admin/edit.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Admin $admin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($admin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
}
