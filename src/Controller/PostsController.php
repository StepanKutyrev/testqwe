<?php

namespace App\Controller;

use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Posts;



class PostsController extends AbstractController
{
    /**
     * @Route("/posts", name="posts")
     */
    public function show(){
        $posts = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findAll();

        if (!$posts) {
            throw $this->createNotFoundException(
                'No product found  '
            );

        }

        return $this->render('posts/index.html.twig', [
            'records' =>  $posts
        ]);

    }
    /**
     * @Route("/post/{id}", name="post" )
     */
    public function index($id): Response
    {
        return $this->render('posts/post.html.twig', [
            'record' =>  $product = $this->getDoctrine()
                ->getRepository(Posts::class)
                ->find($id)
        ]);
    }
    /**
     * @Route("/posts/add", name="add_post")
     */
    public function addpost(Request $request)
    {
        $post = new Posts();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $file = $request->files->get('post')['image_name'];
            $uploads_directory = $this->getParameter('uploads_directory');

            $filename = md5(uniqid()) . '.' .  $file->guessExtension();
            $file->move(
               $uploads_directory,
               $filename
            );
            $post->image_name= $filename;

            $em=$this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

        }
        return $this->render('add_post/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/post/update/{id}", name="update_post")
     */


git init
}
