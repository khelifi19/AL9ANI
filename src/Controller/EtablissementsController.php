<?php

namespace App\Controller;

use App\Entity\Etablissements;
use App\Form\EtablissementsType;
use App\Repository\EtablissementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etablissements')]
class EtablissementsController extends AbstractController
{
    #[Route('/', name: 'app_etablissements_index', methods: ['GET'])]
    public function index(EtablissementsRepository $etablissementsRepository): Response
    {
        return $this->render('etablissements/index.html.twig', [
            'etablissements' => $etablissementsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etablissements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etablissement = new Etablissements();
        $form = $this->createForm(EtablissementsType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etablissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_etablissements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etablissements/new.html.twig', [
            'etablissement' => $etablissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etablissements_show', methods: ['GET'])]
    public function show(Etablissements $etablissement): Response
    {
        return $this->render('etablissements/show.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etablissements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etablissements $etablissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtablissementsType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etablissements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etablissements/edit.html.twig', [
            'etablissement' => $etablissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etablissements_delete', methods: ['POST'])]
    public function delete(Request $request, Etablissements $etablissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etablissement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etablissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etablissements_index', [], Response::HTTP_SEE_OTHER);
    }
}
