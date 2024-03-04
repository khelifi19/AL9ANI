<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
    #[Route('/admin', name: 'app_home_admin')]
    public function homeBack(): Response
    {
        return $this->render('back/homepageBack.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
    #[Route('/admin/uber',name: 'app_uber_page')]
    public function back(): Response
    {
        return $this->render('back/index.html.twig');
    }
}
