<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\Categorie;
use App\Form\ProduitsType;
use App\Form\CategorieType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    #[Route('/back', name: 'app_back')]
    public function index(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    #[Route('/productList', name: 'productList')]
    public function productList(EntityManagerInterface $entityManager): Response
    {
        $produits = $entityManager
            ->getRepository(Produits::class)
            ->findAll();

        return $this->render('back/apps-ecommerce-products.html.twig', [
            'produits' => $produits,
        ]);
    }
    #[Route('/categorylist', name: 'categorylist')]
    public function categorylist(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('back/apps-ecommerce-categories.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/addproduct', name: 'addproduct')]
    public function addproduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setAddeddate(new DateTime());
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('productList', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/apps-ecommerce-products-add.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/singleproduct/{idProduct}", name="singleproduct", methods={"GET"})
     */
    public function single_product(Produits $produit): Response
    {
        return $this->render('back/apps-ecommerce-products-details.html.twig', [
            'produit' => $produit,
        ]);
    }
    #[Route('/editproduct/{idProduct}', name: 'editproduct', methods: ['GET', 'POST'])]
    public function editproduct(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('productList', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/apps-ecommerce-products-edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/editcategory/{id}', name: 'editcategory', methods: ['GET', 'POST'])]
    public function editcategory(Request $request,Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('categorylist', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/apps-ecommerce-category-edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/addcategory', name: 'addcategory', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorylist', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/apps-ecommerce-category-add.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorylist', [], Response::HTTP_SEE_OTHER);
    }

}
