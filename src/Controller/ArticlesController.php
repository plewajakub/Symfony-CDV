<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Formatter\ApiResponseFormatter;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/articles')]
class ArticlesController extends AbstractController
{
    private ArticlesRepository $articlesRepository;
    private ApiResponseFormatter $apiResponseFormatter;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ArticlesRepository $articlesRepository,
        ApiResponseFormatter $apiResponseFormatter,
        EntityManagerInterface $entityManager
    ) {
        $this->articlesRepository = $articlesRepository;
        $this->apiResponseFormatter = $apiResponseFormatter;
        $this->entityManager = $entityManager;
    }

    // Get all articles - accessible by everyone
    #[Route('', name: 'get_all_articles', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $articles = $this->articlesRepository->findAll();
        $transformedArticles = [];

        foreach ($articles as $article) {
            $transformedArticles[] = $article->toArray();
        }

        return $this->apiResponseFormatter
            ->withData($transformedArticles)
            ->response();
    }

    // Get article by ID - accessible by everyone
    #[Route('/{id}', name: 'get_article_by_id', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $article = $this->articlesRepository->find($id);

        if (!$article) {
            return $this->apiResponseFormatter
                ->withMessage('Article not found')
                ->withStatus(Response::HTTP_NOT_FOUND)
                ->response();
        }

        return $this->apiResponseFormatter
            ->withData($article->toArray())
            ->response();
    }

    // Create article - accessible only by users with ROLE_ADMIN or ROLE_SUPER_ADMIN
    #[Route('', name: 'create_article', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have permission to create an article.', statusCode: 403)]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['title']) || empty($data['content'])) {
            return $this->apiResponseFormatter
                ->withMessage('Title and content are required')
                ->withStatus(Response::HTTP_BAD_REQUEST)
                ->response();
        }

        $article = new Articles();
        $article->setTitle($data['title']);
        $article->setContent($data['content']);

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return $this->apiResponseFormatter
            ->withData($article->toArray())
            ->withStatus(Response::HTTP_CREATED)
            ->response();
    }

    // Update article by ID - accessible only by users with ROLE_ADMIN or ROLE_SUPER_ADMIN
    #[Route('/{id}', name: 'update_article', methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have permission to update this article.', statusCode: 403)]
    public function update(int $id, Request $request): JsonResponse
    {
        $article = $this->articlesRepository->find($id);

        if (!$article) {
            return $this->apiResponseFormatter
                ->withMessage('Article not found')
                ->withStatus(Response::HTTP_NOT_FOUND)
                ->response();
        }

        $data = json_decode($request->getContent(), true);

        if (!empty($data['title'])) {
            $article->setTitle($data['title']);
        }

        if (!empty($data['content'])) {
            $article->setContent($data['content']);
        }

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return $this->apiResponseFormatter
            ->withData($article->toArray())
            ->withMessage('Article updated successfully')
            ->response();
    }

    // Delete article by ID - accessible only by users with ROLE_ADMIN or ROLE_SUPER_ADMIN
    #[Route('/{id}', name: 'delete_article', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have permission to delete this article.', statusCode: 403)]
    public function delete(int $id): JsonResponse
    {
        $article = $this->articlesRepository->find($id);

        if (!$article) {
            return $this->apiResponseFormatter
                ->withMessage('Article not found')
                ->withStatus(Response::HTTP_NOT_FOUND)
                ->response();
        }

        $this->entityManager->remove($article);
        $this->entityManager->flush();

        return $this->apiResponseFormatter
            ->withMessage('Article deleted successfully')
            ->response();
    }
}
