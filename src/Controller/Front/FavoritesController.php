<?php

namespace App\Controller\Front;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FavoriteService;

class FavoritesController extends AbstractController
{
    private $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

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
        $this->favoriteService->toggleFavorite($id);
        $this->addFlash('add_to_favorite', 'Film ajouté à la liste des favoris ! ');

        return $this->redirectToRoute('app_favorites', ['id' => $id]);
    }
    
    /**
     * @Route("/favorites/remove/{id}", name="app_favorite_remove")
     *
     */
    public function removeFromFavorite($id, Request $request): Response
    {
        $this->favoriteService->toggleFavorite($id);
        $this->addFlash('remove_from_favorite', 'Film supprimé de la liste des favoris ! ');

        return $this->redirectToRoute('app_favorites');
    }

    /**
     * @Route("/favorites/clear", name="app_favorite_clear")
     *
     */
    public function clearFavorite(Request $request): Response
    {
        $this->favoriteService->clearFavorites();
        $this->addFlash('clear_favorite', 'Liste des favoris supprimée !');

        return $this->redirectToRoute('app_favorites');
    }
}
