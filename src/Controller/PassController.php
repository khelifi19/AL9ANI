<?php

namespace App\Controller;

use App\Entity\Evenement;
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
    #[Route('/admin/pass', name: 'app_pass')]
public function showAllpass(): Response
{
    $pass = $this->getDoctrine()->getRepository(pass::class)->findAll();

    return $this->render('pass/list.html.twig', [
        'pass' => $pass,
    ]);
}
   
#[Route('/admin/pass/create', name: 'app_pass_create')]
public function addPass(Request $request): Response
{
    $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

    $pass = new Pass();

    $form = $this->createForm(FormPassType::class, $pass, [
        'evenements' => $evenements,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $selectedEvenement = $form->get('evenement')->getData();
        $pass->setEvenement($selectedEvenement);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($pass);
        $entityManager->flush();

        return $this->redirectToRoute('app_evenement_etb');
    }

    return $this->render('pass/formpass.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('admin/editpass/{id}', name: 'edit_pass')]
public function editEvent(Pass $pass, Request $request, EntityManagerInterface $entityManager): Response
{
    $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

    $form = $this->createForm(FormPassType::class, $pass, [
        'evenements' => $evenements,
    ]);

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
    #[Route('/gerant/pass', name: 'app_gerantpass')]
    public function showAllgerantpass(): Response
    {
        $pass = $this->getDoctrine()->getRepository(pass::class)->findAll();
    
        return $this->render('pass/listgerant.html.twig', [
            'pass' => $pass,
        ]);
    }
       
    #[Route('/gerant/pass/edit/{id}', name: 'edit_gerantpass')]
public function editgerantEvent(Pass $pass, Request $request, EntityManagerInterface $entityManager): Response
{
    $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

    $form = $this->createForm(FormPassType::class, $pass, [
        'evenements' => $evenements,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $this->addFlash('success', 'Pass updated successfully.');

        return $this->redirectToRoute('app_gerantpass');
    }

    return $this->render('pass/editgerantpass.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/gerant/pass/create', name: 'app_gerantpass_create')]
public function addgerantPass(Request $request): Response
{
    $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

    $pass = new Pass();

    $form = $this->createForm(FormPassType::class, $pass, [
        'evenements' => $evenements,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $selectedEvenement = $form->get('evenement')->getData();
        $pass->setEvenement($selectedEvenement);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($pass);
        $entityManager->flush();

        return $this->redirectToRoute('app_gerantpass');
    }

    return $this->render('pass/formgerantpass.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/delete-gerantpass/{id}', name: 'delete_gerantpass', methods: ['POST'])]
    public function deletegerantPass(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $pass = $entityManager->getRepository(Pass::class)->find($id);

        if ($pass) {
            $entityManager->remove($pass);
            $entityManager->flush();

            $this->addFlash('success', 'Pass deleted successfully');
        }

        return $this->redirectToRoute('app_gerantpass');
    }
}
