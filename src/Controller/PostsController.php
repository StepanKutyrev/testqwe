<?php

namespace App\Controller;

use App\Entity\Likes;
use App\Entity\Users;
use App\Form\PostType;
use Knp\Component\Pager\PaginatorInterface;
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
    public function show(Request $request ,PaginatorInterface  $paginator){
        $user = new Users();
        $likes = new Likes();
        $user = $this->getUser();
        $user_id = $user->getId();
        $posts = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findAll();
        $post = $paginator->paginate(
            $posts,
            $request->query->getInt('page' , 1),
            5
        );

        $likes = $this->getDoctrine()
            ->getRepository(Likes::class)
            ->findByExampleField($user_id);

        if (!$posts) {
            throw $this->createNotFoundException(
                'No product found  '
            );
        }

        return $this->render('posts/index.html.twig', [
            'records' =>  $post,
            'likes' => $likes
        ]);

    }
    /**
     * @Route("/post/{id}", name="post" )
     */
    public function index($id): Response
    {
        return $this->render('posts/post.html.twig', [
            'record' =>  $post = $this->getDoctrine()
                ->getRepository(Posts::class)
                ->find($id)
        ]);
    }
    /**
     * @Route("/posts/add", name="add_post")
     */
    public function addPost(Request $request)
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
     * @Route("/posts/update/{id}", name="update_post")
     */


    public function updatePost(Request $request , int $id)
    {


        $post = new Posts();
        $postData = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findOneBy(['id' => $id]);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
            if ($form->isSubmitted()){
                $fieldData = $form->getData();
                $file = $request->files->get('post')['image_name'];
                $uploads_directory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' .  $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );
                $em= $this->getDoctrine()->getManager();
                $post = $em->getRepository(Posts::class)->find($id);

                $post->setDescription($fieldData->getDescription());
                $post->setImageName($filename);
                $post->setDate($fieldData->getDate());
                $post->setTrueDate($fieldData->getTrueDate());
                $em->persist($post);
                $em->flush();
        }
        return $this->render('posts/edit.html.twig', [
            'form' => $form->createView(),
            'postData'=>$postData
        ]);
    }

}
