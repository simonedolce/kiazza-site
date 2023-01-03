<?php

namespace App\Controller;

use App\Entity\CodAuth;
use App\Entity\User;
use App\Form\CodAuthFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Doctrine\ORM\EntityRepository;

/**
 * Controller di configurazione accessibile solo agli admin
 */
#[IsGranted('ROLE_ADMIN')]
class ConfigurazioneController extends AbstractController
{
    protected ManagerRegistry $doctrine;
    protected EntityRepository $usersRepository;
    protected EntityRepository $codAuthRepository;

    public function __construct(EntityManagerInterface $em,ManagerRegistry $doctrine)
    {
        $this->usersRepository = $em->getRepository(User::class);
        $this->codAuthRepository = $em->getRepository(CodAuth::class);
        $this->doctrine = $doctrine;
    }

    #[Route('/configurazione', name: 'index_configurazione')]
    public function index(Request $request): Response
    {

        $formCodAuth = $this->createForm(CodAuthFormType::class);
        $formCodAuth->handleRequest($request);

        if($formCodAuth->isSubmitted() && $formCodAuth->isValid()){
            $entityManager = $this->doctrine->getManager();

            /** @var CodAuth $codAuth */
            $codAuth = $formCodAuth->getData();

            $ruoli = implode(',',$request->get('cod_auth_form')['ruolo']);
            $codAuth->setRuolo($ruoli);

            $entityManager->persist($codAuth);
            $entityManager->flush();
        }

        $users = $this->usersRepository->findAll();
        $codAuths = $this->codAuthRepository->findAll();

        return $this->render('configurazione/index.html.twig', [
            'users' => $users,
            'codAuths' => $codAuths,
            'formCodAuth' => $formCodAuth->createView(),
            'controller_name' => 'ConfigurazioneController',
        ]);
    }

    #[Route('/ajax-elimina-cod-auth/{id}', name: 'app_ajax_elimina_cod_auth')]
    public function ajaxDeleteCodAuth(Request $request, CodAuth $codAuth): Response
    {

        $response = new Response();

        try {
            $entityManager = $this->doctrine->getManager();
            $entityManager->remove($codAuth);
            $entityManager->flush();
            $response->setContent('OK');
            $response->setStatusCode(Response::HTTP_OK);
        }catch (\Exception $e){
            $response->setContent('NOK');
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;

    }
}