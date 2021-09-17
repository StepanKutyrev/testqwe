<?php

namespace App\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TextController extends AbstractController
{
    /**
     * @Route("/text", name="text")
     */
    public function post()
    {
        return new JsonResponse(
            [
                'status'=>'ok',
            ],JsonResponse::HTTP_CREATED
        );
    }
}
