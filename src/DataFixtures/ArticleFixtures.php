<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use \Datetime;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <=3;$i++){
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDesciption($faker->paragraph());

            $manager->persist($category);

            for($j =1; $j<=mt_rand();$j++){
                $article = new Article();

                $content = '<p>' . join("</p><p>" ,$faker->paragraphs(5) ) . '</p>';
                $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreateAt($faker ->dateTimeBetween('-6 months'))
                    -setCategory($category);

                $manager->persist($article);


                for ($k = 1;$k<= mt_rand(4,10);$k++){
                    $content = '<p>' . join("</p><p>" , $faker->paragraphs(2) ) . '</p>';

                    $now = new \DateTime();
                    $interval = $now->diff($article->getCreateAt());
                    $days = $interval->days;
                    $minimum ='-' .$days . 'days';

                    $comment = new Comment();
                    $comment->setAuthor($faker->name)
                            -setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween($minimum))
                            ->setArticle($article);
                    $manager->persist($comment);
                }

        }


       }

        $manager->flush();
    }
}
