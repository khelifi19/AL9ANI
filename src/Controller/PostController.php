<?php

namespace App\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Post;
use App\Entity\Commentaire;
use App\Form\PostType;
use App\Form\CommentaireType;
use App\Repository\PostRepository;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Options as DompdfOptions;
#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, Request $request): Response
    {
        // Use the correct parameter name ('q' instead of 'p')
        $searchQuery = $request->query->get('q');
    
        if ($searchQuery) {
            $posts = $postRepository->searchPosts($searchQuery);
        } else {
            // If no search query, fetch all posts
            $posts = $postRepository->findAll();
        }

          // Manually paginate the posts
          $currentPage = $request->query->getInt('page', 1); // Get current page number
          $perPage = 5; // Items per page
          $totalPosts = count($posts); // Total number of posts
          $totalPages = ceil($totalPosts / $perPage); // Total number of pages
          $offset = ($currentPage - 1) * $perPage; // Offset for pagination
          $posts = array_slice($posts, $offset, $perPage); // Get posts for the current page

          // Fetch statistics for post categories
        $categoryStatistics = $entityManager->createQueryBuilder()
        ->select('p.categorie, COUNT(p.id) as postCount')
        ->from('App\Entity\Post', 'p')
        ->groupBy('p.categorie')
        ->getQuery()
        ->getResult();
    
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'searchQuery' => $searchQuery,
            'pagination' => [
                'perPage' => $perPage, // Pass the number of items per page
                'currentPage' => $currentPage, // Pass the current page number
                'totalPages' => $totalPages,
            ],
        ]);
    }
    #[Route('/back', name: 'app_postback_index', methods: ['GET'])]
    
    public function indexback(PostRepository $postRepository, Request $request): Response
    {
        // Use the correct parameter name ('q' instead of 'p')
        $searchQuery = $request->query->get('q');
    
        if ($searchQuery) {
            $posts = $postRepository->searchPosts($searchQuery);
        } else {
            // If no search query, fetch all posts
            $posts = $postRepository->findAll();
        }
    
        // Manually paginate the posts
        $currentPage = $request->query->getInt('page', 1); // Get current page number
        $perPage = 5; // Items per page
        $totalPosts = count($posts); // Total number of posts
        $totalPages = ceil($totalPosts / $perPage); // Total number of pages
        $offset = ($currentPage - 1) * $perPage; // Offset for pagination
        $posts = array_slice($posts, $offset, $perPage); // Get posts for the current page
    
        // Fetch category statistics
        $categoryStatistics = $this->getDoctrine()
            ->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->select('p.localisation as categorie', 'COUNT(p.id) as postCount')
            ->groupBy('p.localisation')
            ->getQuery()
            ->getResult();
    
        return $this->render('post/index1.html.twig', [
            'posts' => $posts,
            'searchQuery' => $searchQuery,
            'pagination' => [
                'perPage' => $perPage,
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
            ],
            'categoryStatistics' => $categoryStatistics, // Pass category statistics to the template
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('post')['image'];
                // $file=$jeux->getImagejeux();
                $uploads_directory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );
                $post->setImage($filename);

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_postback_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $post->getImage();
            $post->setImage($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_postback_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_postback_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/commentaire/{idPost}", name="app_postcom")
     */
    public function PackItem(Request $request, PostRepository $postRepository, $idPost, CommentaireRepository $commentaireRepository): Response
    {   
        $post = $postRepository->find($idPost); 
        $commentaire = $commentaireRepository->getPostcom($idPost);
        
        $newCommentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $newCommentaire);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $newCommentaire->setPost($post); // Set the Post before calling add
            $commentaireRepository->add($newCommentaire);
    
            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('post/postitem.html.twig', [
            'commentaire' => $commentaire,
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/generate-pdf', name: 'post_generate_pdf')]
public function generatePdf(Post $post): Response
{
    // Get the HTML content of the page you want to convert to PDF
    $html = $this->renderView('post/show-pdf.html.twig', [
        // Pass any necessary data to your Twig template
        'post' => $post,
    ]);

// Configure Dompdf options
$options = new Options();
$options->set('isHtml5ParserEnabled', true);

// Instantiate Dompdf with the configured options
$dompdf = new Dompdf($options);

// Load HTML content into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

    // Set response headers for PDF download
    $response = new Response($dompdf->output());
    $response->headers->set('Content-Type', 'application/pdf');
    $response->headers->set('Content-Disposition', 'attachment; filename="post.pdf"');

    return $response;
}

}
