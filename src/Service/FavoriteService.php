<?php

namespace App\Service;

use App\Entity\Movie;
use Symfony\Component\HttpFoundation\RequestStack;

class FavoriteService
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        // Request n'est pas disponible dans les services. A la place, on utilisa RequestStack.
        $this->requestStack = $requestStack;
    }

    public function add(Movie $movie){

        $session = $this->requestStack->getSession();
        //  je  créer un tableau depuis ma session ou je recupere ma session qui est déjà un tableau
        $favorite = $session->get("favorite",[]);
        //  je rajoute mon film dans le tableau
        $favorite[$movie->getId()] = $movie;
        //  je rajoute le tableau dans le tiroir de favoris
        // ici favorite fonctionne comme un index de tableau et favorite sera sa valeur
        $session->set("favorite",$favorite);

        return true;
    }

    public function removeFavorite(Movie $movie)
    {
        $session = $this->requestStack->getSession();
        //  je  créer un tableau depuis ma session ou je recupere ma session qui est déjà un tableau
        $favorite = $session->get("favorite",[]);

        unset($favorite[$movie->getId()]);
        //  je rajoute le tableau dans le tiroir de favoris
        // ici favorite fonctionne comme un index de tableau et favorite sera sa valeur
        $session->set("favorite",$favorite);

        return true;
    }

    /**
     * toggle the movie in the favorite session
     */
    public function toggle(Movie $movie){

        $session = $this->requestStack->getSession();
        //  je  créer un tableau depuis ma session ou je recupere ma session qui est déjà un tableau
        $favorite = $session->get("favorite",[]);

        // si il est dans les favoris je l'enleve
        if(isset($favorite[$movie->getId()])){
            unset($favorite[$movie->getId()]);
        }else{
            //  je rajoute mon film dans le tableau
            $favorite[$movie->getId()] = $movie;
        }
        //  je rajoute le tableau dans le tiroir de favoris
        // ici favorite fonctionne comme un index de tableau et favorite sera sa valeur
        $session->set("favorite",$favorite);

        return true;
    }

    /**
     * Empty all the favorite of the session
     */
    public function empty(){

        $this->requestStack->getSession()->remove("favorite");

    }

    /**
     * get all the favorite from the session
     */
    public function getAll(){

        $session = $this->requestStack->getSession();
        
        return $session->get("favorite");

    }

}