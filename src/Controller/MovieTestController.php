<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Season;
use App\Repository\MovieRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieTestController extends AbstractController
{
    /**
     * @Route("/movie/test", name="app_movie_test")
     */
    public function index(): Response
    {
        return $this->render('movie_test/index.html.twig', [
            'controller_name' => 'MovieTestController',
        ]);
    }

     /**
     * Ajouter une entité dans la base de donnée
     * @Route("/movie/test/add", name="app_movie_test_add")
     */
    public function add(ManagerRegistry $doctrine)
    {
        // Ci dessous on récupère le manager de doctrine
        // C'est comme si on récuperait le "manager" qui va s'occuper de traiter avec la base de donnée
        $entityManager = $doctrine->getManager();

        // Ici je créer une instance de mon entité Movie
        $movie = new Movie;

        // $movie est un objet de l'entité Movie
        // On va donner des valeurs aux propriétés de $movie grace aux setters de l'entité Movie
        $movie->setTitle('Stranger Things');
        $movie->setReleaseDate(new DateTime('2018-05-15'));
        $movie->setDuration(50);

        // Pour créer une saison a Stranger Things ...
        $s1 = new Season();
        $s1->setNumber(1); // LA saison 1
        $s1->setEpisodesNumber(6); // 6 épisodes dans la saison 1
        $s1->setMovie($movie); // Le Movie associé a $s1 sera $movie (donc stranger things)

        $s2 = new Season();
        $s2->setNumber(2); // LA saison 2
        $s2->setEpisodesNumber(7); // 7 épisodes dans la saison 1
        $s2->setMovie($movie); // Le Movie associé a $s2 sera $movie (donc stranger things)
        
        // La methode persist permet de sauvegarder l'entité donnée en parametre ($movie) sans pour autant executer la requete sql
        $entityManager->persist($movie);
        $entityManager->persist($s1);
        $entityManager->persist($s2);

        // flush ci dessous va s'occuper d'executer toutes les requetes sql qu'on doit executer
        $entityManager->flush();

        return $this->render('movie_test/index.html.twig', [
            'controller_name' => 'MovieTestController',
        ]);
    }

    /**
     * Modifier une entité Movie
     *
     * @Route("/movie/test/edit/{id}", name="app_movie_test_edit")
     */
    public function edit($id, MovieRepository $movieRepository, ManagerRegistry $doctrine)
    {
        // Ci dessous $movie sera egal a l'entité qui a pour id $id
        $movie = $movieRepository->find($id);

        // Maintenant qu'on a récupérer notre entité Movie, on va lui modifier son titre
        $movie ->setTitle("E.T l'extraterrestre");

        // Puis on sauvegarde dans la base de donnée
        $entityManager = $doctrine->getManager();
        $entityManager->persist($movie);
        $entityManager->flush();
    }
}
