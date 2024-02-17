<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SericeController extends AbstractController
{
    #[Route('/serice', name: 'app_serice')]
    public function index(): Response
    {
        return $this->render('serice/index.html.twig', [
            'controller_name' => 'SericeController',
        ]);
    }

    #[Route('/showserice/{name}', name: 'app_showserice')]
    public function showservice($name): Response
    {
        return $this->render('serice/affiche.html.twig', ['n' => $name]); 
    }
}
