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
use Knp\Component\Pager\PaginatorInterface;


#[Route('/etablissements')]
class EtablissementsController extends AbstractController
{
    #[Route('/', name: 'app_etablissements_index', methods: ['GET'])]
    public function index(EtablissementsRepository $etablissementsRepository, PaginatorInterface $paginator, Request $request): Response

    {
        $etablissements = $etablissementsRepository->findAll();

        $pagination = $paginator->paginate($etablissements, $request->query->getInt('page', 1), // numéro de page par défaut
        3 // nombre d'éléments par page
    );
        return $this->render('etablissements/index.html.twig', [
            'etablissements' => $pagination,
        ]);
    }


    #[Route('/premium/listfavoris', name: 'favoris')]
    public function favoris(EtablissementsRepository $etablissementsRepository): Response
    {
        $favoris = $etablissementsRepository->findBy(['favoris' => true]);

        return $this->render('etablissements/favoris.html.twig', [
        'favoris' => $favoris,
    ]);
    }


    #[Route('/gerant/new', name: 'app_etablissements_new', methods: ['GET', 'POST'])]
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

   #[Route('show/{id}', name: 'app_etablissements_show', methods: ['GET'])]
    public function show(Etablissements $etablissement): Response
    {
        return $this->render('etablissements/show.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }

    #[Route('/gerant/{id}/edit', name: 'app_etablissements_edit', methods: ['GET', 'POST'])]
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

    #[Route('/gerant/{id}', name: 'app_etablissements_delete', methods: ['POST'])]
    public function delete(Request $request, Etablissements $etablissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etablissement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etablissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etablissements_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/premium/ajouter-favoris/{id}', name: 'ajouter_favoris')]
    public function ajouterFavoris(int $id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $etablissement = $entityManager->getRepository(Etablissements::class)->find($id);
    
        if (!$etablissement) {
            throw $this->createNotFoundException('Etablissement non trouvée.');
        }
    
        // Marquer l'établissement comme favori
        $etablissement->setFavoris(true);
        $entityManager->flush();
    
        // Rediriger vers la page des etablissements
        return $this->redirectToRoute('app_etablissements_index', [], Response::HTTP_SEE_OTHER);
    
    }

    
    #[Route('/premium/retirer-favoris/{id}', name: 'retirer_favoris')]
    public function retirerFavoris(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $favori = $entityManager->getRepository(Etablissements::class)->find($id);
    
        if (!$favori) {
            throw $this->createNotFoundException('Etablissement non trouvée.');
        }
    
        // Retirer l'établissement des favoris
        $favori->setFavoris(false);
        $entityManager->flush();
    
        // Rediriger vers la page des favoris
        return $this->redirectToRoute('favoris');
    }
    





}
