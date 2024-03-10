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
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Options as DompdfOptions;
use App\Mailer\MyEmail;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
#[Route('/post')]
class PostController extends AbstractController
{
    private $transactionRepository;
    private $myEmail;
    private $security;
    private $userRepository;

    public function __construct(PostRepository $transactionRepository,Security $security, UserRepository $userRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
        $this->security = $security;
    }
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, Request $request, EntityManagerInterface $entityManager): Response
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
    public function new(Request $request, EntityManagerInterface $entityManager , MyEmail $myEmail): Response
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
            $users = $this->userRepository->findAll(); 
            foreach ($users as $user) {
                $recipient = $user->getEmail(); // Assuming you have a method like getEmail() in your User entity
                $subject = 'New Post';
                $context = [
                    'postTitle' => $post->getTitre(),
                    'postContent' => $post->getDescription(),
                    'username' => $user->getUsername(), // Add any user-specific information you want to include
                ];
                $myEmail->sendEmail($recipient, $subject, $context);
            }

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
    {   $user = $this->security->getUser();
        $post = $postRepository->find($idPost); 
        $commentaire = $commentaireRepository->getPostcom($idPost);
        
        $newCommentaire = new Commentaire();
        if ($user) {
           
            $form = $this->createForm(CommentaireType::class, $newCommentaire);
     
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $newCommentaire->setUser($user);
            $newCommentaire->setPost($post); // Set the Post before calling add
            $commentaireRepository->add($newCommentaire);
    
            return $this->redirectToRoute('app_postcom', ['idPost' => $idPost], Response::HTTP_SEE_OTHER);
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

    public function printPdf(): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $posts = $this->transactionRepository->findAll();
        
        // Generate the HTML content
        $html = $this->renderView('post/print.html.twig', ['posts' => $posts]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Setup the paper size and orientation
        $dompdf->render(); // Render the HTML as PDF

        $filename = sprintf('post-%s.pdf', date('Y-m-d_H-i-s'));

        // Output the generated PDF to Browser (force download)
        return new Response($dompdf->stream($filename, ["Attachment" => true]));
    }
/**
     * @Route("/{idPost}/afficher", name="afficher_evenement")
     */
    public function afficherEvent($idPost):Response
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($idPost);
        $post->setEnable(1);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($post);
        $entityManager->flush();
        return $this->redirectToRoute('app_postback_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{idPost}/masquer", name="masquer_evenement")
     */
    public function masquerEvent($idPost): Response
    {
        $post= $this->getDoctrine()->getRepository(Post::class)->find($idPost);
        $post->setEnable(0);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($post);
        $entityManager->flush();
        return $this->redirectToRoute('app_postback_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/searchByTitre', name: 'search_by_titre', methods: ['GET'])]
    public function searchByTitre(Request $request, PostRepository $contratRepository): JsonResponse
    {
        $titre = $request->query->get('titre');
    
        // Recherche des logements par adresse
        $contrats = $contratRepository->findByTitre($titre);
    
        // Convertir les entités Logement en tableau pour la réponse JSON
        $results = [];
        foreach ($contrats as $contrat) {
            $results[] = [
                'id' => $contrat->getId(),
                'description' => $contrat->getDescription(),
                'datepost' => $contrat->getDatepost(),
                'titre' => $contrat->getTitre(),
                'image' => $contrat->getImage(),
                'localisation' => $contrat->getLocalisation(),
            ];
        }
    
        return $this->json($results);
    }
    #[Route('/loadAllPosts', name: 'load_all_posts', methods: ['GET'])]
public function loadAllLogements(PostRepository $contratRepository): JsonResponse
{
    // Récupérer tous les logements depuis le repository
    $contrats = $contratRepository->findAll();

    // Convertir les entités Logement en tableau pour la réponse JSON
    $results = [];
    foreach ($contrats as $contrat) {
        $results[] = [
                'id' => $contrat->getId(),
                'description' => $contrat->getDescription(),
                'titre' => $contrat->getTitre(),
                'datepost' => $contrat->getDatepost(),
                'image' => $this->generateUrl('uploads', ['path' => 'uploads/' . $contrat->getImage()]),
            
                'localisation' => $contrat->getLocalisation(),
                
                // Assuming you have a route named 'uploads'
                'showPath' => $router->generate('app_post_show', ['id' => $contrat->getId()]),
                'editPath' => $router->generate('app_post_edit', ['id' => $contrat->getId()]),
        ];
    }

    return $this->json($results);
}

}
