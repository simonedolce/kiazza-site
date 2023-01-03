<?php

namespace App\Controller;

use App\Common\CommonFunction;
use App\Entity\Album;
use App\Entity\Dimensione;
use App\Entity\Immagine;
use App\Entity\Single;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityRepository;

class AjaxSpotifySyncController extends AbstractController
{

    protected EntityRepository $repositoryDimensione;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repositoryDimensione = $em->getRepository(Dimensione::class);
    }

    #[Route('/ajax/spotify/sync', name: 'app_ajax_spotify_sync')]
    public function syncAlbums(Request $request,EntityManagerInterface  $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $spotifyAlbums = json_decode($request->headers->get('albums'));
        $objects = [];
        foreach ($spotifyAlbums as $album){

            $urlImmagine = $album->images[0]->url;
            $nome = $album->name;
            $totaleTracce = $album->total_tracks;
            $idSpotify = $album->id;
            $nomiArtisti = implode(',' , array_column($album->artists, 'name'));

            $pathOnServer = 'uploads\albums';
            $absolutePathOnServer = $_SERVER['DOCUMENT_ROOT'] . $pathOnServer;
            $fileName = $idSpotify . '.jpg';

            $dimensioneQuadrata =
                $this->repositoryDimensione->find(Dimensione::DIMENSIONE_QUADRATA);


            CommonFunction::uploadImageToServerFromUrl(
                $urlImmagine,
                $fileName,
                $absolutePathOnServer);

            $immagineObject = new Immagine();
            $immagineObject->setNomeFile($fileName);
            $immagineObject->setPath($pathOnServer . '\\' . $fileName);
            $immagineObject->setDimensione($dimensioneQuadrata);

            $entityManager->persist($immagineObject);

            if($totaleTracce == 1){

                $singoloUtente = new Single();
                $singoloUtente->setNomeSingolo($nome);
                $singoloUtente->setUrlSpotify($idSpotify);
                $singoloUtente->setImmagine($immagineObject);
                $singoloUtente->setUser($user);
                $singoloUtente->setNomeArtista($nomiArtisti);
                $entityManager->persist($singoloUtente);

            } else {

                $albumUtente = new Album();
                $albumUtente->setUrlSpotify($idSpotify);
                $albumUtente->setNomeAlbum($nome);
                $albumUtente->setNumeroTracce($totaleTracce);
                $albumUtente->setImmagine($immagineObject);
                $albumUtente->setUser($user);
                $albumUtente->setNomeArtista($nomiArtisti);
                $entityManager->persist($albumUtente);

            }
        }

        $entityManager->flush();


        return $this->render('ajax_spotify_sync/index.html.twig', [
            'controller_name' => 'AjaxSpotifySyncController',
        ]);
    }
}
