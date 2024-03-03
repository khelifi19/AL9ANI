<?php
namespace App\Controller;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\BillingPortal\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
class PaymentController extends AbstractController
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

    #[Route('/user/checkout/{id}', name: 'checkout')]
    public function checkout(Course $course): RedirectResponse
    {
        
            $courseStripe = [
                'price_data' => [
                    'currency' => 'EUR',
                    'unit_amount' => $course->getPrix(),
                    'product_data' => [
                        'name' => 'course de Foulen Foulen'
                    ],
                ],
                'quantity' => 1
            ];

            $stripeSecretKey = $_ENV['STRIPE_SK'];
           
            $checkout=$this->gateway->checkout->sessions->create([
              
                
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'EUR',
                            'unit_amount' => $course->getPrix() * 8,
                            'product_data' => [
                                'name' => 'course de Foulen Foulen'
                            ],
                        ],
                        'quantity' => 1
                    ]

                ],
                'mode' => 'payment',
                'success_url' => $this->generator->generate('success_url', ['course' => $course->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' =>  $this->generator->generate('cancel_url', ['course' => $course->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

            return  $this->redirect($checkout->url);
     
    }

    #[Route('/success-url/{id}', name: 'success_url')]
    public function successUrl(Course $course): Response
    {
        return $this->render('front/show.html.twig', [
            'course' => $course,
        ]);
    }

    #[Route('/cancel-url/{id}', name: 'cancel_url')]
    public function cancelUrl(Course $course): Response
    {
        $this->em->remove($course);
        $this->em->flush();
        return $this->render('front/payment/cancel.html.twig', [
            'course' => $course,
        ]);
    }
}
