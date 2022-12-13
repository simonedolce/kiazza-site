<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfiloArtistaController extends AbstractController
{
    #[Route('/profilo/rapper', name: 'visualizza_profilo_artista')]
    public function index(): Response
    {
        return $this->render('profilo_rapper/index.html.twig', [
            'controller_name' => 'ProfiloArtistaController',
        ]);
    }

    #[Route('/profilo/modifica', name: 'modifica_profilo_artista')]
    public function modifica(): Response
    {
        return $this->render('profilo_rapper/modifica-profilo.html.twig', [
            'controller_name' => 'ProfiloArtistaController',
        ]);
    }


    #[Route('/profilo/add-album', name: 'aggiungi_album')]
    public function aggiungiAlbum(): Response
    {

        return $this->render('profilo_rapper/add-album.html.twig', [
            'controller_name' => 'ProfiloArtistaController',
        ]);
    }
}
