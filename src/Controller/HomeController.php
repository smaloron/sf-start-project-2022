<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController {

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
        return new Response("Home sweet home vous avez $age ans vous êtes $userName");
    }

    /**
     * @Route("/user/{id<\d+>?5}", name="user",
     * requirements: {"id": "\d+"}
     * )
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function userAction(Request $request,int $id = 5): Response
    {
        $session = $request->getSession();
        return new Response("bonjour ". $session->get("user"). " votre id est $id");
    }

}