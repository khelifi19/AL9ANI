<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Pass;
use App\Form\FormEvenementType;
use Endroid\QrCode\QrCode;
use App\Form\ReservationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EvenementController extends AbstractController
{
   
    #[Route('/admin/evenement', name: 'app_evenement_etb')]
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

    #[Route('/admin/evenement/create', name: 'app_evenement_create')]
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



    #[Route('admin/edit/{id}', name: 'edit_event')]
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
#[Route('/generate-qr-code/{eventId}', name: 'generate_qr_code')]
    public function generateQRCode(int $eventId): JsonResponse
    {
        // QR NA3MLOH PAR ID 
        $baseUrl = $this->generateUrl('app_event_details', ['id' => $eventId], UrlGeneratorInterface::ABSOLUTE_URL);
        $qrCodeData = $baseUrl;

        return $this->json($qrCodeData);
    }
    #[Route('/admin/evenement/sort', name: 'app_evenement_sort', methods: ['GET'])]
    public function sortEvents(Request $request): JsonResponse
    {
        $column = $request->query->get('column', 'nomEvent');
        $order = $request->query->get('order', 'asc');

        // Get sorted events from the database (adjust this part based on your sorting logic)
        $events = $this->getDoctrine()->getRepository(Evenement::class)->findBy([], [$column => $order]);

        // Render the events as HTML (adjust this part based on your HTML structure)
        $html = $this->renderView('evenement/sorted_events.html.twig', [
            'events' => $events,
        ]);

        return new JsonResponse(['html' => $html]);
    }
   
   
    #[Route('/gerant/evenement', name: 'app_gerantevenement')]
public function showEventsgerant(): Response
{
    $events = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

    return $this->render('evenement/listgerant.html.twig', [
        'events' => $events,
    ]);
}


#[Route('/gerant/evenement/edit/{id}', name: 'editeventgerant')]
public function editEventgerant(Evenement $event, Request $request, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(FormEvenementType::class, $event);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $this->addFlash('success', 'Event updated successfully.');

        return $this->redirectToRoute('app_gerantevenement');
    }

    return $this->render('evenement/editgerantevent.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/gerant/evenement/create', name: 'app_gerantevenement_create')]
public function gerantaddEvent(Request $request): Response
{
    $evenement = new Evenement();

    
    $form = $this->createForm(FormEvenementType::class, $evenement);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($evenement);
        $entityManager->flush();

        // Redirect pass bech yzid pass tebe3 levent
        return $this->redirectToRoute('app_gerantpass_create');
    }

    return $this->render('evenement/gerantformevent.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/deletegerant/{id}', name: 'delete_gerantevent')]
public function deletegerantEvent(Evenement $event, EntityManagerInterface $entityManager): Response
{
    $entityManager->remove($event);
    $entityManager->flush();

    $this->addFlash('success', 'Event deleted successfully.');

    return $this->redirectToRoute('app_gerantevenement');
}
}