<?php

namespace App\DataFixtures;

use App\Entity\ArticlesFoot;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        /*$user->setEmail("aurelien@gmail.com");
        $user->setRoles(['ROLE_ADMIN']);
      $password = $this->hasher->hashPassword($user,'aaa');
      $user->setPassword($password);
      $user->setName("fabre");
      $user->setFirstname("aurelien");
      $user->setPseudo("aurel");

        $manager->persist($user);

        $article = new ArticlesFoot();
        $article->setNom("ArticleTest");
        $article->setDescription("desciption");
        $article->setImages("https://www.shutterstock.com/shutterstock/photos/1937437555/display_1500/stock-photo-close-up-of-a-football-action-scene-with-competing-soccer-players-at-the-stadium-1937437555.jpg");
        $article->setIdUser($user);
        $manager->persist($article);

        $manager->flush();*/

        $faker = Faker\Factory::create();

        for($i =0; $i< 20; $i++){

            $user = new User();
            $user->setEmail($faker->email());
            $user->setRoles(['ROLE_USER']);
            $password = $this->hasher->hashPassword($user,'aaa');
            $user->setPassword($password);
            $user->setFirstname($faker->firstName());
            $user->setName($faker->lastName());
            $user->setPseudo($faker->name());

            $manager->persist($user);
            $article = new ArticlesFoot();
            $article->setNom( $faker->randomElement(['foot1','foot2']));
            $article->setDescription($faker->paragraph(10));
            $article->setIdUser($user);
            $manager->persist($article);
            $manager->flush();


        }

    }
}
