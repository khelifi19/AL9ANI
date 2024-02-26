<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Pass;
use App\Form\FormEvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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

}