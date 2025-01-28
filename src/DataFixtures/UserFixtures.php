<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('kuba');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setPassword('$2y$13$9mfYSEdbkTktikqZlDer3.YVigMpGdV2Zus7VQWKCCoVX35YNVH1O');

        $manager->persist($user);
        $manager->flush();
    }
}
