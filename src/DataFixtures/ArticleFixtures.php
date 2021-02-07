<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::Create();

        for ($i = 1; $i <= 3; $i++) {

            $category = new Category();
            $category->setTitle($faker->sentence(2))
                ->setDescription($faker->paragraph(1));

            $manager->persist($category);

            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                $article = new Article();
                $article->setTitle($faker->sentence(4, true))
                    ->setContent($faker->paragraph())
                    ->setImage("https://loremflickr.com/g/320/240/paris")
                    ->setCreatedAt($faker->dateTimeBetween('-30 days'))
                    ->setCategory($category);

                $manager->persist($article);
                for ($k = 1; $k <= mt_rand(2, 3); $k++) {
                    $comment = new Comment();

                    $articleDate = $article->getCreatedAt();
                    $now = new \DateTime();
                    $diff = date_diff($articleDate, $now);
                    $time = $diff->format("-%a days");
                    $comment->setAuthor($faker->name())
                        ->setContent($faker->paragraph(2))
                        ->setArticle($article)
                        ->setCreatedAt($faker->dateTimeBetween($time));

                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}