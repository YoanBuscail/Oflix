<?php

namespace App\Controller\Front;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoritesController extends AbstractController
{
    /**
     * @Route("/favorites", name="app_favorites")
     */
    public function index(Request $request, MovieRepository $movieRepository): Response
    {
        $session = $request->getSession();

        $favoris = $session->get('favoris', []);

        return $this->render('favorites/index.html.twig', [
        'favoris' => $favoris,
        'movieRepository' => $movieRepository,
        ]);
    }
    
    /**
     * @Route("/favorites/add/{id}", name="app_favorite_add")
     */
    public function addToFavorite($id, Request $request): Response
    {
        // Récupérer la session
        $session = $request->getSession();

        // Récupérer le panier de favoris de la session
        $favoris = $session->get('favoris', []);

        // Ajouter le film à la liste de favoris s'il n'y est pas déjà
        if (!in_array($id, $favoris)) {
            $favoris[] = $id;
        }

        // Mettre à jour le panier de favoris dans la session
        $session->set('favoris', $favoris);
        
        $this->addFlash('add_to_favorite', 'Film ajouté à la liste des favoris ! ');

        return $this->redirectToRoute('app_favorites', ['id' => $id]);
    }
    
    /**
     * @Route("/favorites/remove/{id}", name="app_favorite_remove")
     *
     */
    public function removeFromFavorite($id, Request $request): Response
    {
        $session = $request->getSession();

        $favoris = $session->get('favoris', []);

        // Vérifier si l'ID du film à supprimer est présent dans la liste des favoris
        $key = array_search($id, $favoris);

        if ($key !== false) {
            // Si l'ID existe, supprimer de la liste
            unset($favoris[$key]);
            
            // Mettez à jour le panier de favoris dans la session
            $session->set('favoris', $favoris);
        }

        // Rediriger vers la page voulue (par exemple, la page de la liste de favoris)
        return $this->redirectToRoute('app_favorites');
    }
}
