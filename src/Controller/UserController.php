<?php

namespace App\Controller;

use App\Entity\User;
use App\Formatter\ApiResponseFormatter;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api')]
class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private ApiResponseFormatter $apiResponseFormatter,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/users', name: 'app_user', methods: ['GET'])]
    #[IsGranted('ROLE_SUPER_ADMIN', message: 'You are not allowed to access the admin dashboard.', statusCode: 403, exceptionCode: 10010)]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        $transformedUsers = [];
        foreach ($users as $user) {
            $transformedUsers[] = $user->toArray();
        }

        return $this->apiResponseFormatter
            ->withData($transformedUsers)
            ->response();
    }

    #[Route('/users/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            return $this->apiResponseFormatter
                ->withMessage('User not found')
                ->withStatus(Response::HTTP_NOT_FOUND)
                ->response();
        }

        return $this->apiResponseFormatter
            ->withData($user->toArray())
            ->response();
    }

    #[Route('/users', name: 'create_user', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['email']) || empty($data['password'])) {
            return $this->apiResponseFormatter
                ->withMessage('Invalid data')
                ->withStatus(Response::HTTP_BAD_REQUEST)
                ->response();
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($data['password']); // Storing password in plain text (not recommended for production)
        $user->setRoles($data['roles'] ?? ['ROLE_USER']); // Default role to ROLE_USER if none is provided

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->apiResponseFormatter
            ->withData($user->toArray())
            ->withStatus(Response::HTTP_CREATED)
            ->response();
    }

    #[Route('/users/{id}', name: 'update_user', methods: ['PATCH'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->apiResponseFormatter
                ->withMessage('User not found')
                ->withStatus(Response::HTTP_NOT_FOUND)
                ->response();
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        if (isset($data['password'])) {
            $user->setPassword($data['password']); // Storing password in plain text (not recommended for production)
        }

        if (isset($data['roles'])) {
            $user->setRoles($data['roles']);
        }

        $this->entityManager->flush();

        return $this->apiResponseFormatter
            ->withData($user->toArray())
            ->withMessage('User updated successfully')
            ->response();
    }

    #[Route('/users/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->apiResponseFormatter
                ->withMessage('User not found')
                ->withStatus(Response::HTTP_NOT_FOUND)
                ->response();
        }
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->apiResponseFormatter
            ->withMessage('User deleted successfully')
            ->response();
    }

    #[Route('/users/superadmins/find', name: 'find_super_admins', methods: ['GET'])]
    public function findSuperAdmins(): JsonResponse
    {
        $superAdmins = $this->userRepository->findAllSuperAdmins();

        $transformedSuperAdmins = [];
        foreach ($superAdmins as $superAdmin) {
            $transformedSuperAdmins[] = $superAdmin->toArray();
        }

        return $this->apiResponseFormatter
            ->withMessage('Super Admins')
            ->withData($transformedSuperAdmins)
            ->response();
    }

    #[Route('/users/modulo/{modulo}', name: 'find_by_modulo', methods: ['GET'])]
    public function findByModulo(int $modulo): JsonResponse
    {
        $users = $this->userRepository->findAllByModulo($modulo);

        $transformedUsers = [];
        foreach ($users as $user) {
            $transformedUsers[] = $user->toArray();
        }

        return $this->apiResponseFormatter
            ->withMessage('Users by Modulo')
            ->withData($transformedUsers)
            ->response();
    }
}
