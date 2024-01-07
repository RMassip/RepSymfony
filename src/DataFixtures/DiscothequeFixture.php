<?php

namespace App\DataFixtures;

use App\Entity\Artiste;
use App\Entity\Chanson;
use App\Entity\Type;
use DateTimeImmutable;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiscothequeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $types = [];

        $typesData = [
            ['Auteur', 'Personne qui écrit les paroles des chansons'],
            ['Compositeur', 'Personne qui compose la musique des chansons'],
            ['Interprète', 'Personne qui chante ou joue la chanson'],
            ['Arrangeur', 'Personne qui organise la structure musicale de la chanson'],
            ['Musicien', "Personne qui joue d'un instrument de musique dans la chanson"],
        ];

        foreach ($typesData as $typeInfo) {
            $type = (new Type())
                ->setType($typeInfo[0])
                ->setDescription($typeInfo[1]);
        
            $manager->persist($type);
            $types[] = $type;
        }
        
        $manager->flush();

        $chansons = [];
        // Création des chansons
        for ($i=0; $i < 50; $i++) { 
            $dateSortie = DateTimeImmutable::createFromMutable($faker->dateTime());
            $chanson = (new Chanson())->setTitre($faker->sentence(4))
                                        ->setGenre($faker->sentence(1))
                                        ->setLangue($faker->languageCode(1))
                                        ->setDateSortie($dateSortie)
                                        ->setPhotoCouverture("https://picsum.photos/360/360?image=".($i+2));
            $manager->persist($chanson);
            $chansons[] = $chanson;
            $manager->flush();

        }


        $artistes = [];
        for ($i=0; $i < 50; $i++) { 
            // Création des artistes
            $dateNaissance = DateTimeImmutable::createFromMutable($faker->dateTime());
            $artiste= (new Artiste())->setNom($faker->lastName())
                                        ->setPrenom($faker->firstName())
                                        ->setLieuNaissance($faker->city())
                                        ->setPhoto("https://picsum.photos/360/360?image=".($i+25))
                                        ->setDateNaissance($dateNaissance)
                                        ->setEtre($types[rand(0,4)])
                                        ->setDescription($faker->text(50))
                                        ->addParticiper($chansons[rand(0, count($chansons)-1)]);

            $manager->persist($artiste);
            $artistes[] = $artiste;
            $manager->flush();
        }
    }
}
