<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

    /**
     * @Route("/home/{userName}", name="home",
     * defaults={"userName":"Paul"})
     *
     * @param Request $request
     * @param string $userName
     * @return Response
     */
    public function homeAction(Request $request, string $userName = "test"): Response
    {
        $age = $request->query->get('age', 8);
        $session = $request->getSession();
        $session->set("user", "Jane");
        return $this->render("home/index.html.twig", [
            "age" => $age,
            "userName" => $userName,
        ]);
    }

    /**
     * @Route("/user/{id<\d+>?5}", name="user")
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function userAction(Request $request,int $id = 5): Response
    {
        return $this->render("home/user.html.twig", ["id" => $id]);
    }

}