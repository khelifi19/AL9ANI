<?php

namespace App\Controller;

use App\Entity\Course;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CourseController extends AbstractController
{
    #[Route('/courses', name: 'course_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $courses = $entityManager->getRepository(Course::class)->findAll();

        return $this->render('back/course/index.html.twig', [
            'courses' => $courses,
        ]);
    }


    #[Route('/course/{id}', name: 'course_show', methods: ['GET'])]
    public function show(Course $course): Response
    {
        return $this->render('back/course/show.html.twig', [
            'course' => $course,
        ]);
    }



    #[Route('/course/{id}/delete', name: 'course_delete', methods: ['DELETE'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $course = $entityManager->getRepository(Course::class)->find($id);
        if (!$course) {
            throw $this->createNotFoundException('Aucune course trouvée pour cet identifiant : '.$id);
        }
            $entityManager->remove($course);
            $entityManager->flush();
            return $this->redirectToRoute('course_index');
        

        
    }




 








}
