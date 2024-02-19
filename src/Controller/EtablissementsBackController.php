<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementsBackController extends AbstractController
{
    #[Route('/etablissements/back', name: 'app_etablissements_back')]
    public function index(): Response
    {
        return $this->render('Back/index.html.twig', [
            'controller_name' => 'EtablissementsBackController',
        ]);
    }
}
