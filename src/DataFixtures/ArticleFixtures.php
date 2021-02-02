<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitle('title de l\'article ' . $i)
                ->setContent('Contnet de l\'article ' . $i)
                ->setImage('http://placehold.it/350x150')
                ->setCreatedAt(new \DateTime());
            $manager->persist($article);
        }


        $manager->flush();
    }
}