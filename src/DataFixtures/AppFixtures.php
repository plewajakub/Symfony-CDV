<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        $article = new Articles();
        $article->setTitle('First Article');
        // $article->setContent('Content 1');
        $manager->persist($article);

        $article = new Articles();
        $article->setTitle('Second Article');
        // $article->setContent('Content 1');

        $manager->persist($article);
        $manager->flush();
    }
}