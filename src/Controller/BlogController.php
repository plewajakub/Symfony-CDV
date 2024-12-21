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
        return new Response(print_r($articles, true));
    }
}