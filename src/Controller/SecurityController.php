<?php

namespace App\Controller;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route(path:'/self/delete/{username}', name: 'user_delete')]
    public function deleteAccount( EntityManagerInterface $em, string $username,UserRepository $repo) : Response
    {
        $userToDelete = $repo->findOneBy(['username' => $username]);
        
       
        if (!$userToDelete) {
            throw $this->createNotFoundException('User not found.');
        }
        if (true) {
          $em->remove($userToDelete);
         
          $em->flush();
       //close session
           
           $this->addFlash('sup', 'Votre compte a bien été supprimé');
        }
        return $this->redirectToRoute('app_register');

    }
}
