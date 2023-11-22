<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Address;
use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Profile;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = [];
        for ($i=0; $i < 50; $i++) { 
            $dateU = DateTimeImmutable::createFromMutable($faker->dateTime());
            $user = (new User())->setName($faker->name())
                                ->setPassword(sha1("leMotDePasse"))
                                ->setCreatedAt($dateU);
                               

            $manager->persist($user);

            $dateA = DateTimeImmutable::createFromMutable($faker->dateTime());
            $adress = (new Address())->setStreet($faker->streetName())
                                    ->setCodePostal($faker->postcode())
                                    ->setCity($faker->city())
                                    ->setCountry($faker->country())
                                    ->setCreatedAt($dateA)
                                    ->setUser($user);

            $dateP = DateTimeImmutable::createFromMutable($faker->dateTime());


            $profile = (new Profile())->setPicture("https://picsum.photos/360/360?image=".$i)
                                      ->setCoverPicture("https://picsum.photos/360/360?image=".($i+100))
                                      ->setDescription($faker->paragraph())
                                      ->setCreatedAt($dateP)
                                      ->setUser($user);

            $users[] = $user;
            $manager->persist($adress);
            $manager->persist($profile);
            $manager->flush();
            
            
        }

        $categories = [];
for ($i=0; $i < 5; $i++){
    $dateC = DateTimeImmutable::createFromMutable($faker->dateTime());
    $category = (new Category())->setName($faker->sentence(2))
                                ->setDescription($faker->paragraph())
                                ->setImageUrl("https://picsum.photos/360/360?image=".($i+200))
                                ->setCreatedAt($dateC);
    $categories[] = $category;
    $manager->persist($category);
    $manager->flush();
}

for ($i = 0; $i < 100; $i ++){
    $dateArt = DateTimeImmutable::createFromMutable($faker->dateTime());
    $article= (new Article())->setTitle($faker->sentence(3))
                             ->setContent($faker->text(80))
                             ->setImageUrl("https://picsum.photos/360/360?image=".($i+300))
                             ->setCreatedAt($dateArt)
                             ->setAuthor($users[rand(0,count($categories)-1)]);
    $manager->persist($category);
    $manager->flush();
}
}
}