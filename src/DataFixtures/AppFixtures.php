<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const NB_ARTICLES = 40;

    private const CATEGORIES = ["PHP", "Symfony", "JS", "Typescript", "React", "Angular", "Rust"];

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('zh_TW');

        $categories = [];

        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->words($faker->numberBetween(4, 7), true))
                ->setContent($faker->realTextBetween(400, 1500))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years')))
                ->setVisible($faker->boolean(80))
                ->setCategory($faker->randomElement($categories));

            $manager->persist($article);
        }

        $user = new User();
        $user
            ->setEmail('user@bobby.net')
            ->setPassword($this->hasher->hashPassword($user, 'bobby'));

        $manager->persist($user);

        $admin = new User();
        $admin
            ->setEmail('admin@bobby.net')
            ->setPassword($this->hasher->hashPassword($admin, 'admin'))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $token = new ApiToken();
        $token->setToken('MlXbRwjGc3muZMqEVjIfmoo6X');

        $manager->persist($token);

        // Envoyer les modifications en base de données
        $manager->flush();
    }
}
