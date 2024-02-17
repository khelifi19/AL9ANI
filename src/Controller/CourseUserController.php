<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Voiture;
use App\Form\CourseUserForm;
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

    #[Route('/user/course/new', name: 'courseUser_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseUserForm::class, $course);
        $form->handleRequest($request);
        $errorMessage = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $nbPersonne = $form->get('nbPersonne')->getData();
            $voitureModel = ($nbPersonne > 4) ? 'bus' : 'classique';

            // Récupérer la voiture disponible avec le modèle correspondant
            $voiture = $entityManager->getRepository(Voiture::class)->findOneBy([
                'modele' => $voitureModel,
                'disponibilite' => true
            ]);

            if ($voiture) {
                $course->setIdVoiture($voiture);
                $entityManager->persist($course);
                $entityManager->flush();

                return $this->redirectToRoute('courseUser_show', ['id' => $course->getId()]);

            } else {
               
                $errorMessage = 'Aucune voiture disponible pour le moment .Merci de  ressayer plutard';
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
    
        // Vérifier si la date de la course est passée
        if ($course->getDateCourse() < new \DateTime('today')) {
            $errorMessage = 'Cette course ne peut pas être éditée car sa date est passée.';
        } else {
            $errorMessage = '';
        }
    
        // Créer le formulaire d'édition
        $form = $this->createForm(CourseUserForm::class, $course);
        $form->handleRequest($request);
    
        // Traiter la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('courseUser_index');
        }
    
        return $this->render('front/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
            'errorMessage' => $errorMessage,
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




 








}
