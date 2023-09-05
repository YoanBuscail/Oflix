<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FavoriteService;

class FavoritesController extends AbstractController
{
    /**
     * @Route("/favorites", name="app_favorites")
     */
    public function index(FavoriteService $favoriteService): Response
    {   // Normalement on utilise Request $request en paramètre (sans le favoriteService)
        
        /* $session = $request->getSession();
        Pour supprimer la session : $session->remove("favorite");

        $favorites = $session->get("favorite"); */

        return $this->render('favorites/index.html.twig',[
            "favorites" => $favoriteService->getAll()
        ]);
    }
    
    /**
     * @Route("/favorites/add/{id}", name="app_favorites_add")
     */
    public function addToFavorite(Movie $movie, FavoriteService $favoriteService): Response
    {   // Normalement on utilise Request $request en paramètre (sans le favoriteService)
        
        /* $session = $request->getSession();
        Je  créer un tableau depuis ma session ou je recupere ma session qui est déjà un tableau
        $favorite = $session->get("favorite",[]);
        Je rajoute mon film dans le tableau
        $favorite[$movie->getId()] = $movie;
        Je rajoute le tableau dans le tiroir de favoris
        Ici favorite fonctionne comme un index de tableau et favorite sera sa valeur
        $session->set("favorite",$favorite); */

        // j'utilise mon service pour add le film
        $favoriteService->toggle($movie);

        $this->addFlash("success","Le film a été ajouté aux favoris");
        
        return $this->redirectToRoute("app_favorites");
    }
    
    /**
     * @Route("/favorites/remove/{id}", name="app_favorites_delete")
     *
     */
    public function removeFromFavorite(Movie $movie, FavoriteService $favoriteService): Response
    {   // Normalement on utilise Request $request en paramètre (sans le favoriteService)

        /* $session = $request->getSession();
        Je  créer un tableau depuis ma session ou je recupere ma session qui est déjà un tableau
        $favorite = $session->get("favorite",[]);
        J'enleve mon film du tableau
        unset($favorite[$movie->getId()]);
        Je rajoute le tableau dans le tiroir de favoris
        Ici favorite fonctionne comme un index de tableau et favorite sera sa valeur
        $session->set("favorite",$favorite); */

        $favoriteService->toggle($movie);

        $this->addFlash("warning","Le film a été supprimé des favoris");
        
        return $this->redirectToRoute("app_favorites");
    }

    /**
     * @Route("/favorites/clear", name="app_favorite_clear")
     *
     */
    public function clearFavorite(FavoriteService $favoriteService): Response
    {   // Normalement on utilise Request $request en paramètre (sans le favoriteService)
        
        /* $session = $request->getSession();
        
        $session->remove("favorite"); */

        $favoriteService->empty();

        $this->addFlash("warning","Votre liste de favoris a été supprimée");

        
        return $this->redirectToRoute("app_favorites");
    }
}
