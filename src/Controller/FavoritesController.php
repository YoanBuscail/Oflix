<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FavoritesController extends AbstractController
{
    /**
     * Page favoris du site
     * Ci dessous on appelle ca une annotation
     * 
     * @Route("/favorites")
     */
    public function home()
    {
        // Afficher quelque chose
        return $this->render("main/favorites.html.twig");
    }
}