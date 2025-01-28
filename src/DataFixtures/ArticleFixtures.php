<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movies = [
            ['title' => 'The Shawshank Redemption', 'actor' => 'Tim Robbins'],
            ['title' => 'The Godfather', 'actor' => 'Marlon Brando'],
            ['title' => 'The Dark Knight', 'actor' => 'Christian Bale'],
            ['title' => 'Pulp Fiction', 'actor' => 'John Travolta'],
            ['title' => 'Forrest Gump', 'actor' => 'Tom Hanks'],
            ['title' => 'The Matrix', 'actor' => 'Keanu Reeves'],
            ['title' => 'Inception', 'actor' => 'Leonardo DiCaprio'],
            ['title' => 'Fight Club', 'actor' => 'Brad Pitt'],
            ['title' => 'The Lord of the Rings: The Fellowship of the Ring', 'actor' => 'Elijah Wood'],
            ['title' => 'The Avengers', 'actor' => 'Robert Downey Jr.']
        ];

        foreach ($movies as $movie) {
            $article = new Articles();
            $article->setTitle($movie['title']);
            $article->setContent("Starring: {$movie['actor']}");

            // Persist the article
            $manager->persist($article);
        }

        // Flush all persisted data to the database
        $manager->flush();
    }
}