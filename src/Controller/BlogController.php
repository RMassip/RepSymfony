<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/')] // on définit la route / (donc route par défaut de tout le site) pour cette fonction ShowHelloWorld
    public function ShowHelloWorld(): Response
    {
        return new Response('Hello World'); // on ne fait qu'afficher Hello World
    }

    #[Route('/blog/{id}/{name}', name: 'app_blog', requirements: ["id" => "\d{2,6}", "name" => "[a-zA-Z]{5,50}"])]
    public function index(int $id, string $name): Response
    {
        return $this->render('blog/index.html.twig', [
            'id' => $id,
            'name' => $name,
        ]);
    }

    #[Route('/blog/articles', name: 'app_blog_articles')]
    public function showArticles(ArticleRepository $repoArticle, CategoryRepository $repoCategory): Response
    {
    $articles = $repoArticle->findAll();
    $categories = $repoCategory->findAll();

    return $this->render('blog/index.html.twig', [
        'articles' => $articles,
        'categories' => $categories,
    ]);
    }

    #[Route('/article/{slug}', name: 'app_single_article')]
    public function single(ArticleRepository $repoArticle,CategoryRepository $repoCategory, string $slug):Response{
        $article = $repoArticle->findOneBySlug($slug);
        $categories = $repoCategory->findAll();
        return $this->render('blog/single.html.twig', ['article' => $article,'categories' => $categories]);
    }

    #[Route('blog/category/{slug}', name: 'app_articles_by_category')]
    public function articlesByCategory(CategoryRepository $repoCategory, string $slug):Response{
        $articles = [];
        $categorie = $repoCategory->findOneBySlug($slug);
        $categories = $repoCategory->findAll();
        if($categorie != null){
            $articles = $categorie->getArticles();
        }
        
        return $this->render('blog/articles_by_category.html.twig', ['articles' => $articles,'categories' => $categories,'categoryName' => $categorie->getName(),]);
    }

    #[Route('/hello', name: 'hello')]
    public function showHello(CategoryRepository $repoCategory):Response{
        $categories = $repoCategory->findAll();
        return $this->render('blog/accueil.html.twig', ['categories' => $categories]);
    }
}   