<?php

namespace App\Controller;

use App\Entity\CodAuth;
use App\Entity\User;
use App\Form\CodAuthFormType;
use App\Form\RegistrationFormType;
use App\Repository\CodAuthRepository;
use App\Security\LoginAuthAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{

    protected EntityRepository $codAuthRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->codAuthRepository = $em->getRepository(CodAuth::class);
    }

    #[Route('/register/{base64}', name: 'app_register')]
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager,
                             UserAuthenticatorInterface $authenticator,
                             LoginAuthAuthenticator $formAuthenticator,
                             $base64): Response
    {

        $decoded = base64_decode($base64);
        if(!$this->isValidCodAuth($decoded)){
            return $this->redirectToRoute('app_cod_auth');
        }

        /** @var CodAuth $codAuth */
        $codAuth = $this->codAuthRepository->findOneBy(array('codice'=> $decoded));


        $user = new User();

        $user->setUsername($codAuth->getUsernameProvvisorio());
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $roles[] = 'ROLE_ADMIN';
            $user->setRoles($roles);
            $entityManager->remove($codAuth);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $authenticator->authenticateUser(
                $user,
                $formAuthenticator,
                $request);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/codAuth', name: 'app_cod_auth')]
    public function codAuth(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $result = null;
        $formCodAuth = $this->createForm(CodAuthFormType::class);
        $formCodAuth->handleRequest($request);

        $result = $this->render('registration/cod-auth-register.html.twig', ['codAuthForm' => $formCodAuth->createView()]);

        if($formCodAuth->isSubmitted()) {
            /** @var CodAuth $codAuth */
            $codAuth = $formCodAuth->getData();

            /** @var CodAuthRepository $codiceAuthFounded */
            /** @var CodAuth $codiceAuthFounded */
            $codiceAuthFounded = $this->codAuthRepository->findOneByCodice($codAuth->getCodice());

            if ($this->isValidCodAuth($codAuth->getCodice())) {
                $result = $this->redirectToRoute('app_register', ['base64' => base64_encode($codiceAuthFounded->getCodice())]);
            }

        }

        return $result;
    }

    protected function isValidCodAuth($codAuth)
    {
        /** @var CodAuth $codiceAuthFounded */
        $codiceAuthFounded = $this->codAuthRepository->findOneByCodice($codAuth);

        if ($codiceAuthFounded instanceof CodAuth) {
            if ($codAuth === $codiceAuthFounded->getCodice()) {
                return true;
            }
        }
        return false;
    }

}
