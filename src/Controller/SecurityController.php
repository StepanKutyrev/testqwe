<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="login")
     */
    public function login(Request $request , AuthenticationUtils $utils , TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {

        $user = new Users();
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
//        $token = $jwtManager->create($user);
//        dd($token);

        return
                $this->render('security/login.html.twig', [
                'error' =>$error,
                'last_username' => $lastUsername,
            ]);

    }

    /**
     * @Route ("/api/logout" , name="logout")
     */
    public function logout(){
        return $this->redirect($this->generateUrl('/api/login'));
    }

}
