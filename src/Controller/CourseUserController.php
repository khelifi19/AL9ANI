<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\User;
use App\Entity\Voiture;
use App\Form\CourseUserForm;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CourseUserController extends AbstractController
{
    #[Route('/user/courses', name: 'courseUser_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $courses = $entityManager->getRepository(Course::class)->findAll();

        return $this->render('front/indexFront.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/user/course/new/{user}', name: 'courseUser_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ,User $user): Response
{
    $course = new Course();
    $form = $this->createForm(CourseUserForm::class, $course);
    $form->handleRequest($request);
    $errorMessage = '';

    if ($form->isSubmitted() && $form->isValid()) {
        $nbPersonne = $form->get('nbPersonne')->getData();
        $voitureModel = ($nbPersonne > 4) ? 'bus' : 'classique';

        // Vérifie si une voiture est disponible dès maintenant
        if ($course->isCarAvailableNow()) {
            $voiture = null;
            $date = $course->getDate();

            // Tant qu'aucune voiture n'est trouvée et qu'il reste des voitures à vérifier
            while (!$voiture) {
                $voituresDisponibles = $entityManager->getRepository(Voiture::class)->findBy([
                    'modele' => $voitureModel,
                    'disponibilite' => true
                ]);

                foreach ($voituresDisponibles as $voitureDisponible) {
                    if ($voitureDisponible->isDisponibleAtDate($date) ) {
                        $voiture = $voitureDisponible;
                        break;
                    }
                }

                if (!$voiture) {
                    // Si aucune voiture n'est trouvée, sortir de la boucle
                    break;
                }
            }

            if ($voiture) {
                $prix_base = 50;
                $frais_passagers = $nbPersonne * 0.5; 
                $frais_chauffeur = 10; 
                $frais_vehicule = ($voiture->getModele() === 'Bus') ? 50 : 30;
                $prix_total = $prix_base + $frais_passagers + $frais_vehicule + $frais_chauffeur;

                $course->setIdVoiture($voiture);
                $course->setPrix($prix_total);
                $course->setUser($user);
                $entityManager->persist($course);
                $entityManager->flush();

                return $this->redirectToRoute('checkout', ['id' => $course->getId()]);
            } else {
                $errorMessage = 'Aucune voiture disponible pour le moment. Merci de réessayer plus tard.';
            }
        } else {
            $errorMessage = 'Aucune voiture disponible pour le moment. Merci de réessayer plus tard.';
        }
    }

    return $this->render('front/new.html.twig', [
        'form' => $form->createView(),
        'errorMessage' => $errorMessage,
    ]);
}
    
    #[Route('/user/course/{id}', name: 'courseUser_show', methods: ['GET'])]
    public function show(Course $course): Response
    {
        return $this->render('front/show.html.twig', [
            'course' => $course,
        ]);
    }

    #[Route('/user/course/{id}/edit', name: 'courseUser_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {   
       
        $course = $entityManager->getRepository(Course::class)->find($id);
    
        // Vérifier si la course existe
        if (!$course) {
            throw $this->createNotFoundException('Aucune course trouvée pour cet identifiant : ' . $id);
        }
    
    

    
        // Créer le formulaire d'édition
        $form = $this->createForm(CourseUserForm::class, $course);
        $form->handleRequest($request);
    
        // Traiter la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('courseUser_show', ['id' => $course->getId()]);

        }
    
        return $this->render('front/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
          
        ]);
    }
    
    
    #[Route('/user/course/{id}/delete', name: 'courseUser_delete', methods: ['DELETE'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $course = $entityManager->getRepository(Course::class)->find($id);
        if (!$course) {
            throw $this->createNotFoundException('Aucune course trouvée pour cet identifiant : '.$id);
        }
            $entityManager->remove($course);
            $entityManager->flush();
            return $this->redirectToRoute('courseUser_index');
        

        
    }

    #[Route('/user/course/{id}/delete2', name: 'courseUser_delete2', methods: ['DELETE'])]
    public function delete2(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $course = $entityManager->getRepository(Course::class)->find($id);
        if (!$course) {
            throw $this->createNotFoundException('Aucune course trouvée pour cet identifiant : '.$id);
        }
            $entityManager->remove($course);
            $entityManager->flush();
            return $this->redirectToRoute('courseUser_apres');
        

        
    }


 
    #[Route('/user/courses/avant/{user}', name: 'courseUser_avant', methods: ['GET'])]
    public function coursesAvantDateSysteme(EntityManagerInterface $entityManager,User $user): Response
    {
        $currentDate = new \DateTime();
        $coursesAvantDateSysteme = $entityManager->getRepository(Course::class)
            ->createQueryBuilder('c')
            ->where('c.date < :currentDate')
            ->andWhere('c.user = :id')
            ->setParameter('currentDate', $currentDate)
            ->setParameter('id', $user->getId())
            ->getQuery()
            ->getResult();
    
        return $this->render('front/courses_avant.html.twig', [
            'courses' => $coursesAvantDateSysteme,
        ]);
    }
    
    #[Route('/user/courses/apres/{user}', name: 'courseUser_apres', methods: ['GET'])]
    public function coursesApresOuEgaleDateSysteme(EntityManagerInterface $entityManager,User $user): Response
    {
        $currentDate = new \DateTime();
        $coursesApresDateSysteme = $entityManager->getRepository(Course::class)
            ->createQueryBuilder('c')
            ->where('c.date >= :currentDate')
            ->andWhere('c.user = :id')
            ->setParameter('currentDate', $currentDate)
            ->setParameter('id', $user->getId())
            ->getQuery()
            ->getResult();
    
        return $this->render('front/courses_apres.html.twig', [
            'courses' => $coursesApresDateSysteme,
        ]);
    }





   


  


    

}
