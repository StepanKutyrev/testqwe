<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
//use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $passwordEncoder, TokenStorageInterface $tokenStorage)
    {

        $user = new Users();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
//            $user->setRoles(['ROLE_USER']);
            $user->setRole('ROLE_USER');
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
//            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
//            $tokenStorage->setToken($token);
            return $this->redirect($this->generateUrl('login'));
        }

        return $this->render(
            'registration/index.html.twig',
            array('form' => $form->createView())
        );
    }
}
