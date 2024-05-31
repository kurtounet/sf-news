<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_ARTICLES = 40;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('zh_TW');

        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->words($faker->numberBetween(4, 7), true))
                ->setContent($faker->realTextBetween(400, 1500))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years')))
                ->setVisible($faker->boolean(80));

            $manager->persist($article);
        }

        // Envoyer les modifications en base de données
        $manager->flush();
    }
}
