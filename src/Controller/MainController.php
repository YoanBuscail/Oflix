<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Page d'accueil du site
     * Ci dessous on appelle ca une annotation
     * 
     * @Route("/")
     */
    public function home()
    {
        // Afficher quelque chose
        return $this->render("main/home.html.twig");
    }
}