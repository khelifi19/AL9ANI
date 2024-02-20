<?php

namespace App\Controller;

use App\Entity\Pass;
use App\Form\FormPassType;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class PassController extends AbstractController
{
    #[Route('/pass', name: 'app_pass')]
public function showAllpass(): Response
{
    $pass = $this->getDoctrine()->getRepository(pass::class)->findAll();

    return $this->render('pass/list.html.twig', [
        'pass' => $pass,
    ]);
}
   
    
    #[Route('/pass/create', name: 'app_pass_create')]
    public function addPass(Request $request): Response
    {
        $pass = new Pass();

        $form = $this->createForm(FormPassType::class, $pass);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pass);
            $entityManager->flush();

            // bech ken yheb yzid event ekhr wala li howa
            return $this->redirectToRoute('app_evenement');
        }

        return $this->render('pass/formpass.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/editpass/{id}', name: 'edit_pass')]
    public function editEvent(Pass $pass, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormPassType::class, $pass);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            $this->addFlash('success', 'Pass updated successfully.');
    
            return $this->redirectToRoute('app_pass');
        }
    
        return $this->render('pass/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/delete-pass/{id}', name: 'delete_pass', methods: ['POST'])]
    public function deletePass(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $pass = $entityManager->getRepository(Pass::class)->find($id);

        if ($pass) {
            $entityManager->remove($pass);
            $entityManager->flush();

            $this->addFlash('success', 'Pass deleted successfully');
        }

        return $this->redirectToRoute('app_pass');
    }
   
}
