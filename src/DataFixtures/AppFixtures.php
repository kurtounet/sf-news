<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $article = new Article();
        $article
            ->setTitle("Mon premier article")
            ->setContent("Mon contenu")
            ->setCreatedAt(new DateTime())
            ->setVisible(true);

        $manager->persist($article);
        // Envoyer les modifications en base de données
        $manager->flush();
    }
}
