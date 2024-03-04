<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HOMEController extends AbstractController
{
    #[Route('/h/o/m/e', name: 'app_h_o_m_e')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HOMEController',
        ]);
    }
}
