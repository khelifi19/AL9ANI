<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\User;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
#[Route('/commentaire')]
class CommentaireController extends AbstractController
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/', name: 'app_commentaire_index', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $user = $this->security->getUser();
       
        if ($user) {
           
            $form = $this->createForm(CommentaireType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setUser($user);
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_postcom', [], Response::HTTP_SEE_OTHER);
        }
        }else{
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
       

        return $this->renderForm('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_show', methods: ['GET'])]
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {$user = $this->security->getUser();
        if ($user) {
           
            $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_postcom', [], Response::HTTP_SEE_OTHER);
        }
        }else{
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/new/{idPost}", name="app_commentaire_new_one", methods={"GET", "POST"}, requirements={"idPost":"\d+"})
     * 
     */
    public function new1(Request $request, CommentaireRepository $commentaireRepository,PostRepository $postRepository,$idPost, EntityManagerInterface $entityManager): Response
    {   $post = $postRepository->find($idPost);
        $commentaire = new Commentaire();
        $commentaire->setPost($post);
        $user = $this->security->getUser();
        if ($user) {
           
            $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($commentaire);
            $entityManager->flush();
            $commentaire->setPost($post);
            return $this->redirectToRoute('app_postcom', [], Response::HTTP_SEE_OTHER);
        }
        }else{
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('post/postitem.html.twig', [
            'commentaire' => $commentaire,
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
