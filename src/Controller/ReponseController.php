<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Entity\Reclamation;
use App\Form\ReponseType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ReponseRepository;


#[Route('/reponse')]
class ReponseController extends AbstractController
{
    public function index(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator, ReponseRepository $ReponseRepository): Response
    {
        // Utilisation du repository directement pour la cohérence et la clarté
        $queryBuilder = $ReponseRepository->createQueryBuilder('r');
    
        $pagination = $paginator->paginate(
            $queryBuilder, // Passer le QueryBuilder directement
            $request->query->getInt('page', 1), // Numéro de la page
            5 // Limite par page
        );
    
        return $this->render('reponse/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }


    #[Route('/admin/new', name: 'app_reponse_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reponse = new Reponse();
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reponse);
            $entityManager->flush();

            return $this->redirectToRoute('app_reponse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/addrep.html.twig', [
            'reponse' => $reponse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reponse_show', methods: ['GET'])]
    public function show(Reponse $reponse): Response
    {
        return $this->render('reponse/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_reponse_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('back', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/updaterep.html.twig', [
            'reponse' => $reponse,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'app_reponse_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, Reponse $reponse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reponse->getId(), $request->request->get('_token'))) {
            $pre = $entityManager
                ->getRepository(Reponse::class)
                ->find($reponse->getId());
            $reclamations = $entityManager
                ->getRepository(Reclamation::class)
                ->find($reponse->getIdRec());
            $reclamations->setEtat(0);
            $entityManager->persist($reclamations);
            $entityManager->flush();
            $entityManager->remove($reponse);
            $entityManager->flush();
        }
        return $this->redirectToRoute('back', [], Response::HTTP_SEE_OTHER);

    }



    #[Route('/admin/back/pdf', name: 'app_reponse_pdf')]
public function generatePdf(Pdf $pdf): Response
{
    $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
    $reponses = $this->getDoctrine()->getRepository(Reponse::class)->findAll();

    //HTML
    $html = $this->renderView('back/pdf.html.twig', [
        'reclamations' => $reclamations,
        'reponses' => $reponses,
    ]);

    $filename = 'reclamations_' . time() . '.pdf';

    // generate KnpSnappyBundle
    $pdf->generateFromHtml($html, $filename, [
        'lowquality' => true,
    ]);

    $response = new Response(file_get_contents($filename));
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

    register_shutdown_function(function () use ($filename) {
        @unlink($filename);
    });

    return $response;
}
}