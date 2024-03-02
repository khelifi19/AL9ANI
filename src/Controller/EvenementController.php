<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Pass;
use App\Form\FormEvenementType;
use App\Form\ReservationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementController extends AbstractController
{
   
    #[Route('/evenement/etb', name: 'app_evenement_etb')]
public function showEventsEtb(): Response
{
    $events = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

    return $this->render('evenement/list.html.twig', [
        'events' => $events,
    ]);
}
#[Route('/evenement', name: 'app_evenement')]
public function showAllEvents(): Response
{
    $events = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

    return $this->render('evenement/index.html.twig', [
        'events' => $events,
    ]);
}

    #[Route('/evenement/create', name: 'app_evenement_create')]
    public function addEvent(Request $request): Response
    {
        $evenement = new Evenement();

        
        $form = $this->createForm(FormEvenementType::class, $evenement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            // Redirect pass bech yzid pass tebe3 levent
            return $this->redirectToRoute('app_pass_create');
        }

        return $this->render('evenement/formevent.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/edit/{id}', name: 'edit_event')]
public function editEvent(Evenement $event, Request $request, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(FormEvenementType::class, $event);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $this->addFlash('success', 'Event updated successfully.');

        return $this->redirectToRoute('app_evenement_etb');
    }

    return $this->render('evenement/edit.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/delete/{id}', name: 'delete_event')]
public function deleteEvent(Evenement $event, EntityManagerInterface $entityManager): Response
{
    $entityManager->remove($event);
    $entityManager->flush();

    $this->addFlash('success', 'Event deleted successfully.');

    return $this->redirectToRoute('app_evenement_etb');
}
#[Route('/reserver', name: 'app_reserver')]
public function reserver(Request $request): Response
{
    $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();
    $passes = $this->getDoctrine()->getRepository(Pass::class)->findAll();

    $form = $this->createForm(ReservationFormType::class, null, [
        'evenements' => $evenements,
        'passes' => $passes,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
    }

    return $this->render('evenement/reserver.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/evenement/pdf', name: 'app_evenement_pdf')]
public function generatePdf(Pdf $pdf): Response
{
    $events = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

    $html = $this->renderView('evenement/eventspdf.html.twig', [
        'events' => $events,
        
    ]);

    $filename = 'events_' . time() . '.pdf';

    $pdf->generateFromHtml($html, $filename, [
        'lowquality' => true,
        'images' => true,
    
    ]);

    $response = new Response(file_get_contents($filename));
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

    register_shutdown_function(function () use ($filename) {
        @unlink($filename);
    });

    return $response;
}   
#[Route('/eventdetails/{id}', name: 'app_event_details')]
public function showEventDetails(int $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();

    $event = $entityManager->getRepository(Evenement::class)->find($id);

    if (!$event) {
        throw $this->createNotFoundException('Event not found');
    }

    $passes = $entityManager->getRepository(Pass::class)->findBy(['evenement' => $event]);

    return $this->render('evenement/eventdetails.html.twig', [
        'event' => $event,
        'passes' => $passes,
    ]);
}

}