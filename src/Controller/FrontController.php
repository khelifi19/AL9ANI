<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Reclamation;
use App\Entity\Reponse;
use App\Form\ReclamationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReponseType;





class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(): Response
    {
        return $this->render('front/blog.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    /**
     * @Route("/reclamation", name="reclamation_new", methods={"GET","POST"})
     */
    public function newn(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();
        $reponses = $entityManager
            ->getRepository(Reponse::class)
            ->findAll();
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setIdUser(1);
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_success');
        }

        return $this->renderForm('front/reclamation.html.twig', [
            'reclamations' => $reclamations,
            'reponses' => $reponses,
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/reclamation/success", name="reclamation_success")
     */

    public function success(): Response
    {
        return $this->render('reclamation/success.html.twig');
    }

    /**
     * @Route("/reclamation/new", name="reclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();
        $reponses = $entityManager
            ->getRepository(Reponse::class)
            ->findAll();
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setIdUser(1);
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_success');
        }

        return $this->renderForm('front/reclamation.html.twig', [
            'reclamations' => $reclamations,
            'reponses' => $reponses,
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/back", name="back", methods={"GET","POST"})
     */
    public function indexback(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();
        $reponses = $entityManager
            ->getRepository(Reponse::class)
            ->findAll();
        $reclamationsp = $paginator->paginate(
            $reclamations, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->renderForm('back/index1.html.twig', [
            'reclamationsp' => $reclamationsp,
            'reclamations' => $reclamations,
            'reponses' => $reponses,
        ]);
    }
    /**
     * @Route("admin/addreponse", name="addreponse", methods={"GET","POST"})
     */
    public function addreponse(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reponse = new Reponse();
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);
        $ide = $_GET['id'];
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->find($ide);
        if ($form->isSubmitted() && $form->isValid()) {
            $reponse->setIdRec($reclamations);
            $entityManager->persist($reponse);
            $entityManager->flush();
            $reclamations->setEtat(1);
            $entityManager->persist($reclamations);
            $entityManager->flush();
            return $this->redirectToRoute('back', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('back/addrep.html.twig', [
            'reponse' => $reponse,
            'form' => $form,
        ]);
    }
}
