<?php

namespace App\Controller;

use App\Entity\Etablissements;
use App\Form\Etablissements1Type;
use App\Repository\EtablissementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/etablissements/back')]
class EtablissementsBackController extends AbstractController
{
    #[Route('/', name: 'app_etablissements_back_index', methods: ['GET'])]
    public function index(EtablissementsRepository $etablissementsRepository): Response
    {
        return $this->render('etablissements_back/index.html.twig', [
            'etablissements' => $etablissementsRepository->findAll(),
        ]);
    }


    #[Route('/{id}', name: 'app_etablissements_back_show', methods: ['GET'])]
    public function show(Etablissements $etablissement): Response
    {
        return $this->render('etablissements_back/show.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }


    #[Route('/{id}', name: 'app_etablissements_back_delete', methods: ['POST'])]
    public function delete(Request $request, Etablissements $etablissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etablissement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etablissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etablissements_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
