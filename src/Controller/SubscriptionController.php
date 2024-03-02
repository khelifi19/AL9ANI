<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Entity\User;
use App\Form\SubscriptionType;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/subscription')]
class SubscriptionController extends AbstractController
{
    #[Route('/', name: 'app_subscription_index', methods: ['GET'])]
    public function index(SubscriptionRepository $subscriptionRepository): Response
    {
        return $this->render('subscription/index.html.twig', [
            'subscriptions' => $subscriptionRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_subscription_new', methods: ['GET', 'POST'])]
    #[ParamConverter('user', class: 'App\Entity\User', options: ['id' => 'id'])]
    public function new(User $user,  EntityManagerInterface $entityManager): Response
    {
        // Find the user by ID
        
        
    
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
    
        
       
    
            // If not, add ROLE_PREMIUM
            $user->setRoles(['ROLE_PREMIUM']);
    
            // Create a new subscription
            $subscription = new Subscription();
            $subscription->setUser($user);
            $subscription->setDateDebut(new \DateTime());
            $subscription->setDateFin((new \DateTime())->add(new \DateInterval('P1Y')));
            $subscription->setPrice(20);
    
            // Persist and flush
            $entityManager->persist($subscription);
            $entityManager->flush();
       
    
        // Render a Twig template
      return $this->redirectToRoute('checkout_premium', ['id' => $subscription->getId()]);

    }
    

    #[Route('/{id}', name: 'app_subscription_show', methods: ['GET'])]
    public function show(Subscription $subscription): Response
    {
        return $this->render('subscription/show.html.twig', [
            'subscription' => $subscription,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_subscription_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Subscription $subscription, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SubscriptionType::class, $subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_subscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('subscription/edit.html.twig', [
            'subscription' => $subscription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subscription_delete', methods: ['POST'])]
    public function delete(Request $request, Subscription $subscription, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subscription->getId(), $request->request->get('_token'))) {
            $entityManager->remove($subscription);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_subscription_index', [], Response::HTTP_SEE_OTHER);
    }
}
