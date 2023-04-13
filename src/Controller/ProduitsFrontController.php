<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shop')]
class ProduitsFrontController extends AbstractController
{
    #[Route('/', name: 'app_produits_front_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $produits = $entityManager
            ->getRepository(Produits::class)
            ->findAll();

        return $this->render('front/shop.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/new', name: 'app_produits_front_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produits_front/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{idProduct}', name: 'app_produits_front_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('produits_front/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{idProduct}/edit', name: 'app_produits_front_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produits_front/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{idProduct}', name: 'app_produits_front_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getIdProduct(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }
        return $this->redirectToRoute('productList', [], Response::HTTP_SEE_OTHER);
    }
    
}
