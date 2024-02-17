<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class VoitureController extends AbstractController
{
    #[Route('/voitures', name: 'voiture_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $voitures = $entityManager->getRepository(Voiture::class)->findAll();

        return $this->render('back/voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/voiture/new', name: 'voiture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $modele = $form->get('modele')->getData();
            
            // Assigner le nombre de places en fonction du modèle
            if ($modele === 'Bus') {
                $voiture->setNbPlace(9);
                
            } elseif ($modele === 'Sportive' || $modele === 'Classique') {
                $voiture->setNbPlace(4);
            }
            

            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('voiture_index');
        }

        return $this->render('back/voiture/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/voiture/{id}', name: 'voiture_show', methods: ['GET'])]
    public function show(Request $request, EntityManagerInterface $entityManager): Response
    {
        $id = $request->attributes->get('id');
        $voiture = $entityManager->getRepository(Voiture::class)->find($id);

        if (!$voiture) {
            throw $this->createNotFoundException('La voiture avec l\'ID ' . $id . ' n\'existe pas.');
        }

        return $this->render('back/voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    #[Route('/voiture/{id}/edit', name: 'voiture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $voiture = $entityManager->getRepository(Voiture::class)->find($id);

        if (!$voiture) {
            throw $this->createNotFoundException('Aucune voiture trouvée pour cet identifiant : '.$id);
        }

        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modele = $form->get('modele')->getData();
            
            // Assigner le nombre de places en fonction du modèle
            if ($modele === 'Bus') {
                $voiture->setNbPlace(9);
                
            } elseif ($modele === 'Sportive' || $modele === 'Classique') {
                $voiture->setNbPlace(4);
            }
            
            $entityManager->flush();

            return $this->redirectToRoute('voiture_index');
        }

        return $this->render('back/voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/voiture/{id}/delete', name: 'voiture_delete')]
    public function delete(VoitureRepository $voiture, EntityManagerInterface $entityManager, int $id): Response
{
    $voiture = $entityManager->getRepository(Voiture::class)->find($id);

    if (!$voiture) {
        throw $this->createNotFoundException('Aucune voiture trouvée pour cet identifiant : '.$id);
    }

    
        $entityManager->remove($voiture);
        $entityManager->flush();
    

    return $this->redirectToRoute('voiture_index');
}
}
