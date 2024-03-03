<?php

namespace App\Controller;

use App\Entity\Postule;
use App\Form\PostuleType;
use App\Repository\PostuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
#[Route('/postule')]
class PostuleController extends AbstractController
{
    #[Route('/', name: 'app_postule_index', methods: ['GET'])]
    public function index(PostuleRepository $postuleRepository): Response
    {
        return $this->render('back/postule/index.html.twig', [
            'postules' => $postuleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_postule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {
        $postule = new Postule();
        $form = $this->createForm(PostuleType::class, $postule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($postule);
            $entityManager->flush();



//email



// Create a Mailer object


// Create an Email object
$email = (new TemplatedEmail())

// Set the "From address"
->from( $postule->getEmail())

->to(
  'yassine.khelifi@esprit.tn'
    # 'email2@gmail.com',
    # 'email3@gmail.com'
)



// Set a "subject"
->subject('Postule')
->attachFromPath('/Users/yass/Desktop/back/index.html')
->htmlTemplate('emails/postule.html.twig')
->context([
    'postule'=>$postule
]);







    $mailer->send($email);


    


            return $this->redirectToRoute('afficher', ['id' => $postule->getId()]);
            }

        return $this->renderForm('front/postule/new.html.twig', [
            'postule' => $postule,
            'form' => $form,
        ]);
    
    }
    #[Route('/{id}', name: 'app_postule_show', methods: ['GET'])]
    public function show(Postule $postule): Response
    {
        return $this->render('back/postule/show.html.twig', [
            'postule' => $postule,
        ]);
    }
    
    #[Route('/{id}', name: 'afficher', methods: ['GET'])]
    public function afficher(Postule $postule): Response
    {
        return $this->render('front/postule/show.html.twig', [
            'postule' => $postule,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_postule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Postule $postule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostuleType::class, $postule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('afficher', ['id' => $postule->getId()]);
        }

        return $this->renderForm('front/postule/edit.html.twig', [
            'postule' => $postule,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_postule_delete2', methods: ['POST'])]
    public function delete2(Postule $postule, EntityManagerInterface $entityManager): Response
    {
        // Supprime l'entité postule de la base de données
        $entityManager->remove($postule);
        $entityManager->flush();

        // Redirige vers la page de liste des postules après la suppression
        return $this->redirectToRoute('app_postule_index');
    }


    

}
