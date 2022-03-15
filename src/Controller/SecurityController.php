<?php

namespace App\Controller;

use App\Entity\Administrator;
use App\Form\AdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'error' => $authUtils->getLastAuthenticationError(),
            'username' => $authUtils->getLastUsername()
        ]);
    }

    #[Route('/register-admin', name: 'admin_register')]
    public function adminRegister(Request $request,
                                  EntityManagerInterface $manager): Response{
        $admin = new Administrator();

        $form = $this->createForm(
            AdminType::class, $admin
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($admin);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'security/admin-register.html.twig',
            ['adminForm' => $form->createView()]
        );
    }
}
