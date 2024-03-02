<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPremiumController extends AbstractController
{
    #[Route('/user/premium', name: 'app_user_premium')]
    public function index(): Response
    {
        return $this->render('user_premium/index.html.twig', [
            'controller_name' => 'UserPremiumController',
        ]);
    }
    #[Route('/user/premium/checkout', name: 'checkout_premium')]
    public function checkout(): Response
    {
        return $this->render('user_premium/checkout.html.twig', [
            'controller_name' => 'UserPremiumController',
        ]);
    }
}
