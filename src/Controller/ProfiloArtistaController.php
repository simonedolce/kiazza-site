<?php

namespace App\Controller;

use App\Common\CommonFunction;
use App\Entity\Avatar;
use App\Entity\BannerProfilo;
use App\Entity\Dimensione;
use App\Entity\Immagine;
use App\Form\FormModificaProfiloType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityRepository;

class ProfiloArtistaController extends AbstractController
{


    protected EntityRepository $repositoryDimensione;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repositoryDimensione = $em->getRepository(Dimensione::class);
    }

    #[Route('/profilo/rapper/{id}', name: 'visualizza_profilo_artista')]
    public function index(User $user): Response
    {

        return $this->render('profilo_rapper/index.html.twig', [
            'artista' => $user,
            'controller_name' => 'ProfiloArtistaController',
        ]);
    }

    #[Route('/profilo/modifica', name: 'modifica_profilo_artista')]
    public function modifica(Request $request, SluggerInterface $slugger, EntityManagerInterface  $entityManager): Response
    {
        $urlChiamataSync =
        $request->server->get('SYMFONY_APPLICATION_DEFAULT_ROUTE_URL') .
        substr($this->generateUrl('app_ajax_spotify_sync'),1);


        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(FormModificaProfiloType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $avatarFile = $request->files->get('form_modifica_profilo')['avatar']['idImmagine']['file'];
            $bannerFile = $request->files->get('form_modifica_profilo')['bannerProfilo']['idImmagine']['file'];


            if($avatarFile){
                $avatarFileName =
                    substr(CommonFunction::generateFileName($avatarFile,$slugger), 0, 6)
                    . '.' . $avatarFile->guessExtension();

                $avatarPath = str_replace('{idUtente}',$user->getId(),$this->getParameter('avatar_directory'));
                $avatarServerPath = $this->getParameter('project_dir') . $avatarPath;
                $avatarDimensione = $this->repositoryDimensione->find(Dimensione::DIMENSIONE_QUADRATA);

                if($user->getAvatar()){
                    $avatarImgObj =  $user->getAvatar()->getIdImmagine();
                    $avatar = $user->getAvatar();
                } else {
                    $avatarImgObj = new Immagine();
                    $avatar = new Avatar();
                }
                $avatarImgObj->setNomeFile($avatarFileName);
                $avatarImgObj->setPath($avatarPath);
                $avatarImgObj->setDimensione($avatarDimensione);

                $avatarFile->move($avatarServerPath, $avatarImgObj->getNomeFile());

                $avatar->setIdUtente($user);
                $avatar->setIdImmagine($avatarImgObj);

                $entityManager->persist($avatarImgObj);
                $entityManager->persist($avatar);

            }

            if($bannerFile){
                $bannerFileName =
                    substr(CommonFunction::generateFileName($bannerFile,$slugger), 0, 6)
                    . '.' . $bannerFile->guessExtension();

                $bannerPath = str_replace('{idUtente}',$user->getId(),$this->getParameter('banner_directory'));

                $bannerServerPath = $this->getParameter('project_dir') . $bannerPath;

                $bannerDimensione = $this->repositoryDimensione->find(Dimensione::DIMENSIONE_RETTANGOLARE);

                if($user->getBannerProfilo()){
                    $bannerImgObj = $user->getBannerProfilo()->getIdImmagine();
                    $banner = $user->getBannerProfilo();
                } else {
                    $bannerImgObj = new Immagine();
                    $banner = new BannerProfilo();
                }

                $bannerImgObj->setNomeFile($bannerFileName);
                $bannerImgObj->setPath($bannerPath);
                $bannerImgObj->setDimensione($bannerDimensione);

                $bannerFile->move($bannerServerPath, $bannerImgObj->getNomeFile());

                $entityManager->persist($bannerImgObj);

                $banner->setIdUtente($user);
                $banner->setIdImmagine($bannerImgObj);

                $entityManager->persist($banner);

            }

            try {
                $entityManager->persist($user);
                $entityManager->flush();

            } catch (FileException $e) {

            }

        }


        return $this->render('profilo_rapper/modifica-profilo.html.twig', [
            'form' => $form->createView(),
            'urlChiamataSync' => $urlChiamataSync,
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
