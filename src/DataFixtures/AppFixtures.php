<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\DataFixtures\Provider\OflixProvider;
use App\Entity\Casting;
use DateTime;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Person;
use App\Entity\Season;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /**
     * Fonction qui va s'executer quand on va charger les fixtures (envoyer les données en bdd)
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // On crée une instance de Faker 
        // Lors de l'instanciation on définit la localisation => français
        // Ici on créer un faker français tt simplement
        $faker = Factory::create('fr_FR');

        // On instancie notre Provider (fournisseur de données) OflixProvider
        $provider = New OflixProvider();

         // un tableau vide pour stocker nos genre
         $genreList = [];

         // Boucle 20 fois pour créer 20 genres
         for ($i = 1; $i <= 20; $i++) {
             // on crée une entité
             $genre = new Genre();
             // on lui définit un nom qu'on récupère depuis le provider
             $genre->setName($provider->movieGenre());
 
             // on l'ajoute à notre tableau $genreList[]
             $genreList[] = $genre;
 
             // on persist l'entité, avec l'entity manager fourni
             $manager->persist($genre);
         }

         // On créer un tableau ou on va ajouter 100 acteurs
         $personList = [];
         // On ajoute 100 Person (Acteurs)
         for ($p = 1; $p <= 100; $p++) {
            // Nouvelle Person
            $person = new Person();
            // On définit son prenom
            $person->setFirstname($faker->firstName());
            // On définit son Nom
            $person->setLastname($faker->lastName());
            $personList[] = $person;
            // On persiste
            $manager->persist($person);
         }
 
         // dump($genreList);
 
         // On boucle 20 fois pour créer 20 films/séries
         for ($m = 1; $m <= 20; $m++) {
            // On créer une instance de l'entité Movie (On créer un film)
             $movie = new Movie();
             // on définit un titre au film à l'aide du provider
             $movie->setTitle($provider->movieTitle());
           
             /* $type = mt_rand(0, 1) === 1 ? 'Film' : 'Série'; */
             $type = $faker->randomElement(['Film', 'Série']);
             // Définit le type
             $movie->setType($type);
             // Définit la date de sortie en utilisant faker => sortie il y a 100 ans
             $movie->setReleaseDate($faker->dateTimeBetween('-100 year'));
             // Définit la durée
             $movie->setDuration($faker->numberBetween(20, 300));
             // Définit l'image du film
             $movie->setPoster($faker->imageUrl(520, 740, $movie->getTitle()));
             // Définit une note
             $movie->setRating($faker->randomFloat(1, 0, 5));
             // Définit un court résumé
             $movie->setSummary($faker->text(100));
             // Définit un résumé
             $movie->setSynopsis($faker->text(200));
 
             // ici on va associer un ou des genres au film courant
             // par ex. le 1er de la liste
             // @todo à randomiser : par ex. de 1 à 3 genres au hasard
             for ($g = 1; $g <= mt_rand(1,3); $g++) {
                $movie->addGenre($genreList[mt_rand(1,19)]);
              }
 
             // les saisons POUR LES SAISONS
             // @todo à randomiser : par ex. un nombre de saions au hasard avec nbres d'épisodes au hasard
             $season = new Season();
             $season->setNumber(1);
             $season->setEpisodesNumber(6);
             // on l'associe à la série
             $season->setMovie($movie);
             // on persiste la saison
             $manager->persist($season);
 
             // On ajoute 3 à 5 casting par film créée au hasard 
             for ($c = 1; $c <= mt_rand(3,5); $c++) {
                // On créer une instance de l'entité Casting
                $casting = new Casting();
                // On définit le rôle de ce casting
                $casting->setRole($faker->name());
                // On définit l'ordre d'importance de ce casting
                $casting->setCreditOrder($c);
                // On définit les 2 associations de Casting : movie et person
                $casting->setMovie($movie);
                $casting->setPerson($personList[$c]);
                $manager->persist($casting);
             }
             $manager->persist($movie);
         }

        $manager->flush();
    }
}
