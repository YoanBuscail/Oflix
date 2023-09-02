<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FavoriteService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /* public function addFavorite($id)
    {
        $favorites = $this->getFavorites();

        if (!in_array($id, $favorites)) {
            $favorites[] = $id;
            $this->setFavorites($favorites);
        }
    }

    public function removeFavorite($id)
    {
        $favorites = $this->getFavorites();

        $key = array_search($id, $favorites);

        if ($key !== false) {
            unset($favorites[$key]);
            $this->setFavorites($favorites);
        }
    } */

    public function toggleFavorite($id)
    {
    $favorites = $this->getFavorites();

    $key = array_search($id, $favorites);

    if ($key !== false) {
        unset($favorites[$key]);
        } else {
            $favorites[] = $id;
        }

    $this->setFavorites($favorites);
    }

    public function clearFavorites()
    {
        $this->session->remove('favoris');
    }

    public function getFavorites()
    {
        return $this->session->get('favoris', []);
    }

    private function setFavorites($favorites)
    {
        $this->session->set('favoris', $favorites);
    }

}