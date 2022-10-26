<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class HelloController extends AbstractController

    {     
        private array $messages = [
            ["message" => 'Hello', 'created'=>'2022/09/27'],
            ["message"=>'Bye', 'created'=>'2022/08/26'],
            ["message"=>"Good Morning", "created"=>"2021/07/22"]
        ];    
        public $number=2;    

        #[Route('/{limit<\d+>?3}', name: 'index')]
        public function index($limit):Response
            {

          
                return $this->render(
                    'hello/index.html.twig',
                    [
                        'slices'=> $this->messages,
                        'limit'=> $limit
                    ]
                    );

                //return new Response(implode(',', array_slice($this->messages,0,$limit)));
            }


        #[Route('/messages/{id<\d>}', name: 'app_show_one')]    
        public function showOne(int $id): Response
            {
                return $this->render(
                    'hello/show_one.html.twig',
                    [
                        'message' =>$this->messages[$id]
                    ]
                );
               // return new Response($this->messages[$id]);
            }
    }
