<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Season;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

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

         // un tableau vide pur stocker nos
         $genreList = [];

         for ($i = 1; $i <= 20; $i++) {
             // on crée une entité
             $genre = new Genre();
             // on la met à jour
             $genre->setName('Genre #' . $i);
 
             // on l'ajoute à sa liste
             $genreList[] = $genre;
 
             // on persist l'entité, avec l'entity manager fourni
             $manager->persist($genre);
         }
 
         // dump($genreList);
 
         // 20 films/séries
         for ($m = 1; $m <= 20; $m++) {
 
             $movie = new Movie();
             // on met à jour ses propriétés
             $movie->setTitle('Film #' . $m);
             // 1 chance sur 2 que ce soit un film => 'Film' ou 'Série'
             $type = mt_rand(0, 1) === 1 ? 'Film' : 'Série';
             $movie->setType($type);
             $movie->setReleaseDate(new DateTime('2018-05-15'));
             $movie->setDuration(50);
             $movie->setPoster('https://m.media-amazon.com/images/M/MV5BN2ZmYjg1YmItNWQ4OC00YWM0LWE0ZDktYThjOTZiZjhhN2Q2XkEyXkFqcGdeQXVyNjgxNTQ3Mjk@._V1_SX300.jpg');
             $movie->setRating(4.8);
             $movie->setSummary('1983, à Hawkins dans l\'Indiana. Après la disparition d\'un garçon de 12 ans dans des circonstances mystérieuses, la petite ville du Midwest est témoin d\'étranges phénomènes.');
             $movie->setSynopsis('A Hawkins, en 1983 dans l\'Indiana. Lorsque Will Byers disparaît de son domicile, ses amis se lancent dans une recherche semée d’embûches pour le retrouver. Dans leur quête de réponses, les garçons rencontrent une étrange jeune fille en fuite. Les garçons se lient d\'amitié avec la demoiselle tatouée du chiffre "11" sur son poignet et au crâne rasé et découvrent petit à petit les détails sur son inquiétante situation. Elle est peut-être la clé de tous les mystères qui se cachent dans cette petite ville en apparence tranquille…');
 
             // ici on va associer un ou des genres au film courant
             // par ex. le 1er de la liste
             // @todo à randomiser : par ex. de 1 à 3 genres au hasard
             $movie->addGenre($genreList[0]);
 
             // les saisons POUR LES SAISONS
             // @todo à randomiser : par ex. un nombre de saions au hasard avec nbres d'épisodes au hasard
             $season = new Season();
             $season->setNumber(1);
             $season->setEpisodesNumber(6);
             // on l'associe à la série
             $season->setMovie($movie);
             // on persiste la saison
             $manager->persist($season);
 
             $manager->persist($movie);
         }

        $manager->flush();
    }
}
