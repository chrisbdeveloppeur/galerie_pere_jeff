<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Expo;
use App\Entity\TextMenuBurger;
use App\Form\AdminType;
use App\Repository\ExpoRepository;
use App\Repository\SecurityTokenRepository;
use App\Repository\TextMenuBurgerRepository;
use App\Repository\YearDirectoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterByMailController extends AbstractController
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
     * @Route("/new/{token}", name="admin_new_by_mail", methods={"GET","POST"})
     */
    public function newByMail(Request $request, UserPasswordEncoderInterface $passwordEncoder, $token, SecurityTokenRepository $tokenRepository, EntityManagerInterface $em): Response
    {
        $securityToken = $tokenRepository->findOneBy(['token' => $token ]);

        if ($securityToken !== null){
//            dd('Token vérif success');
            $admin = new Admin();
            $form = $this->createForm(AdminType::class, $admin);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($securityToken);
                $em->flush();
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
        }else{
            $message = 'Le jeton de sécurité est incorrect';
            $this->addFlash('danger', $message);
            return $this->redirectToRoute('home');
        }

        return $this->render('admin/new.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
            'galeries' => $this->galeries,
            'text_menu_burger' => $this->textMenuBurger,
            'expo' => $this->expo,
        ]);
    }
}
