<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Bridge\Doctrine\Middleware\Debug\DBAL3\Statement;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, User::class);
    }


    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findAllSuperAdmins()
    {
        $sql = 'SELECT * FROM "user" WHERE CAST("roles" AS text) ~ :role';
        $result = $this->entityManager->getConnection()->executeQuery($sql, ['role' => 'ROLE_SUPER_ADMIN']);
        return $this->getEntityManager()->getRepository(User::class)->findBy(['id' => array_column($result->fetchAllAssociative(), 'id')]);
    }

    public function findAllByModulo(int $modulo): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('MOD(u.id, :modulo) = 0')
            ->setParameter('modulo', $modulo)
            ->getQuery()
            ->getResult();
    }
}
