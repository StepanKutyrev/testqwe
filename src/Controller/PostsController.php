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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    public function ApiShowPostsAndLikes(Request $request ,PaginatorInterface  $paginator ){
        $user = new Users();
        $likes = new Likes();
        $asd = $request->headers->get('userId');
        $user_id = $asd;

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

        return $this->json([$post , $likes]);

    }


    public function ApiAddPost(Request $request )
    {
        $post = new Posts();
        $form = $this->createForm(PostType::class ,$post);
        $form->handleRequest($request);
        if (!$form->isSubmitted()){
            $file = $request->files->get('image_name');
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' .  $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $post->image_name= $filename;
            $post->setDescription($request->request->get('description'));
            $post->setImageName($filename);
            $post->setDate($request->request->get('date'));
            $time = $request->request->get('true_date');
            $newTime =new \DateTime($time);
            $post->setTrueDate($newTime);
            $em=$this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

        }
        return $this->json($post);
    }

    public function ApiUpdatePost(Request $request , int $id )
    {
//        $json = utf8_encode($request->getContent());
//        $data = json_decode($json);


        $post = new Posts();
        $form = $this->createForm(PostType::class ,$post);
        $form->handleRequest($request);
        $postData = $this->getDoctrine()
            ->getRepository(Posts::class)
            ->findOneBy(['id' => 2]);
        if (!$postData) {
            throw $this->createNotFoundException(sprintf(
                'No post found '
            ));
        }
        if (!$form->isSubmitted()){
            $file = $request->files->get('image_name');
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' .  $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );

            $postData->image_name= $filename;
            $postData->setDescription($request->request->get('description'));
            $postData->setImageName($filename);
            $postData->setDate($request->request->get('date'));
            $time = $request->request->get('true_date');
            $newTime =new \DateTime($time);
            $postData->setTrueDate($newTime);

            $em= $this->getDoctrine()->getManager();
            $post = $em->getRepository(Posts::class)->find($id);
            $em->persist($postData);
            $em->flush();
        }

        return $this->json([$post , $postData]);

    }


}
