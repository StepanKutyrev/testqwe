<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TextController extends AbstractController
{
    /**
     * @Route("/ajax", name="_recherche_ajax")
     */
    public function ajaxAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            return new JsonResponse(array('data' => 'this is a json response'));
        }

        return new Response('This is not ajax!', 400);
    }
}
