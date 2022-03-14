<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    #[Route('/person', name: 'app_person')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        PersonRepository $repository): Response
    {
        $person = new Person();

        $form = $this->createForm(
            PersonType::class, $person
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($person);
            $manager->flush();
            return $this->redirectToRoute('app_person');
        }


        return $this->render('person/index.html.twig', [
            'personForm' => $form->createView(),
            'personList' => $repository->findAll(),
        ]);
    }
}
