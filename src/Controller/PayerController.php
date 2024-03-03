<?php
namespace App\Controller;
use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\BillingPortal\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
class PayerController extends AbstractController
{
    private EntityManagerInterface $em;
    private UrlGeneratorInterface $generator;
    private $gateway;
    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $generator)
    {
        $this->em = $em;
        $this->generator = $generator;

        $this->gateway= new StripeClient($_ENV['STRIPE_SK']);
    }
    #[Route('/user/checkout/{id}', name: 'checkout_premium')]
    #[ParamConverter('subscription', class: 'App\Entity\Subscription', options: ['id' => 'id'])]
    public function checkout(Subscription $subscription): RedirectResponse
    {
        
            $subscriptionStripe = [
                'price_data' => [
                    'currency' => 'EUR',
                    'unit_amount' => $subscription->getPrice() * 80,
                    'product_data' => [
                        'name' => 'Subscription de Foulen Foulen'],
                ],
                'quantity' => 1
            ];

            $stripeSecretKey = $_ENV['STRIPE_SK'];
           
            $checkout=$this->gateway->checkout->sessions->create([
              
                
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'EUR',
                            'unit_amount' => $subscription->getPrice() * 8,
                            'product_data' => [
                                'name' => 'Subscription de Foulen Foulen'      ],
                        ],
                        'quantity' => 1
                    ]

                ],
                'mode' => 'payment',

                'success_url' => $this->generator->generate('success_premium', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' =>  $this->generator->generate('cancel_premium', ['id' => $subscription->getId()], UrlGeneratorInterface::ABSOLUTE_URL),         ]);

return  $this->redirect($checkout->url);

}
#[Route('/success-url', name: 'success_premium')]
    
    public function successUrl(): Response
    {
        return $this->render('payment/success.html.twig');
    }

    #[Route('/cancel-url/{id}', name: 'cancel_premium')]
    #[ParamConverter('subscription', class: 'App\Entity\Subscription', options: ['id' => 'id'])]
    public function cancelUrl(Subscription $subscription): Response
    {
        $this->em->remove($subscription);
        $this->em->flush();
        return $this->render('payment/failed.html.twig');   }
}
