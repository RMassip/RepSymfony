<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/')] // on définit la route / (donc route par défaut de tout le site) pour cette fonction home
    public function ShowHelloWorld(): Response
    {
        return new Response('Hello World !! ;)'); // on ne fait qu'afficher son prénom et nom de famille
    }

    #[Route('/blog/{id}/{name}', name: 'app_blog', requirements: ["id" => "\d{2,6}", "name" => "[a-zA-Z@]{5,50}"])]
    public function index(int $id, string $name): Response
    {
        return $this->render('blog/index.html.twig', [
            'id' => $id,
            'name' => $name,
        ]);
    }
}