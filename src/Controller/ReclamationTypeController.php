<?php

// src/Controller/ReclamationController.php
namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation/new", name="reclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_success');
        }

        return $this->render('reclamation/test.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reclamation/success", name="reclamation_success")
     */
    
    public function success(): Response
    {
        return $this->render('reclamation/success.html.twig');
    }
}



