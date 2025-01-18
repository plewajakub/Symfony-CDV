<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
class BlogController extends AbstractController
{
    public function __construct(
        private ArticlesRepository $articlesRepository)
    {

    }
    #[Route('/', 'blog')]
    public function mainPage(): Response
    {
        $articles = $this->articlesRepository->findAll();
        
        $transformedArticles = [];
        foreach($articles as $article) {
            $transformedArticles[] = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
            ];
        }
        return new Response(json_encode($transformedArticles));
    }
}