<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créez le premier film
        $movie1 = new Movie();
        $movie1->setTitle('Inception');
        $movie1->setReleaseDate(new \DateTime('2010-07-16'));
        $movie1->setDuration(148);
        $movie1->setType('Film');
        $movie1->setSummary('Inception est un film de science-fiction réalisé par Christopher Nolan.');
        $movie1->setSynopsis('Le film raconte l\'histoire de Dom Cobb, un voleur d\'esprit, qui pénètre dans les rêves de ses cibles pour voler leurs secrets les plus précieux.');
        $movie1->setPoster('https://media.senscritique.com/media/000004710747/300/inception.jpg');
        $movie1->setRating('4.8');

        // Créez le deuxième film
        $movie2 = new Movie();
        $movie2->setTitle('La La Land');
        $movie2->setReleaseDate(new \DateTime('2016-12-09'));
        $movie2->setDuration(128);
        $movie2->setType('Film');
        $movie2->setSummary('La La Land est une comédie musicale réalisée par Damien Chazelle.');
        $movie2->setSynopsis('Le film raconte l\'histoire de Mia, une actrice en herbe, et Sebastian, un pianiste de jazz, qui tombent amoureux tout en poursuivant leurs rêves à Los Angeles.');
        $movie2->setPoster('https://fr.web.img4.acsta.net/pictures/16/11/10/13/52/169386.jpg');
        $movie2->setRating('4.5');

        // Créez le quatrième film
        $movie3 = new Movie();
        $movie3->setTitle('Breaking Bad');
        $movie3->setReleaseDate(new \DateTime('2008-01-20'));
        $movie3->setDuration(60);
        $movie3->setType('Serie');
        $movie3->setSummary('Breaking Bad est une série télévisée créée par Vince Gilligan.');
        $movie3->setSynopsis('La série suit l\'histoire de Walter White, un professeur de chimie devenu producteur de méthamphétamine après avoir été diagnostiqué d\'un cancer en phase terminale.');
        $movie3->setPoster('https://fr.web.img5.acsta.net/pictures/19/06/18/12/11/3956503.jpg');
        $movie3->setRating('4.9');

        // Persistez les films
        $manager->persist($movie1);
        $manager->persist($movie2);
        $manager->persist($movie3);

        // Appliquez les changements en base de données
        $manager->flush();
    }
}

