<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts) : Response
    {

        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll(),
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function indexByOne(MicroPost $post) : Response

    {
            if(!$post->getTitle()){
                return $this->render('micro_post/show_error.html.twig');
            }else

        return $this->render('micro_post/show.html.twig', [
            'post'=>$post
        ]);


        }
    #[Route('/micro-post/add', name: 'app_micro_post_add', priority:2)]
    public function add(Request $request, MicroPostRepository $posts): Response
    {

        $microPost = new MicroPost();
        $form = $this ->createForm(MicroPostType::class, new MicroPost);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $post= $form->getData();
            $post->setCreated(new DateTime());
            $posts->save($post,true);

            //add flash message
                $this->addFlash('succes', 'micropost have been added');
                return $this->redirectToRoute('app_micro_post');
            //redirect to different page

        }

        return $this->renderForm('micro_post/new.html.twig',
        [
            'form'=>$form
        ]
    );
    }

    #[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
    public function edit(MicroPost $post,Request $request, MicroPostRepository $posts): Response
    {        
        $form = $this ->createForm(MicroPostType::class,$post);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $post= $form->getData();
            $posts->save($post,true);

            //add flash message
                $this->addFlash('succes', 'micropost have been updated');
                return $this->redirectToRoute('app_micro_post');
            //redirect to different page
        }

        return $this->renderForm('micro_post/edit.html.twig',
        [
            'form'=>$form
        ]
    );
    }

}