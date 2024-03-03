<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Service\TwilioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class CourseController extends AbstractController
{
    #[Route('/courses', name: 'course_index', methods: ['GET'])]
public function index(CourseRepository $courseRepository): Response
{
    $courses = $courseRepository->findAll();

    return $this->render('back/course/index.html.twig', [
        'courses' => $courses,
    ]);
   
}

public function calendrier(CourseRepository $courseRepository): Response
    {
        $courses = $courseRepository->findAll();

        $rdvs = [];

        foreach ($courses as $course) {
            $rdvs[] = [
                'id' => $course->getId(), // Ou $course->getCourseId() selon la méthode réelle dans votre entité
                'start' => $course->getDate()->format('Y-m-d H:i:s'), // Ou autre format de date si nécessaire
                'title' =>  'ID de la course :' .$course->getId() ,
              
                'backgroundColor' => '#FF5733', // Couleur de fond personnalisée
                'borderColor' => '#FF5733', // Couleur de la bordure personnalisée
                'textColor' => '#FF5733', // Couleur du texte personnalisée
            ];
        }

        $data = json_encode($rdvs);

        return $this->render('back/calender/calender.html.twig', compact('data'));
    }


    #[Route('/course/{id}', name: 'course_show', methods: ['GET'])]
    public function show(Course $course): Response
    {
        return $this->render('back/course/show.html.twig', [
            'course' => $course,
        ]);
    }



    #[Route('/course/{id}/delete', name: 'course_delete', methods: ['DELETE'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager, TwilioService $twilioService): Response
    {
       
    
        // Récupérez l'entité Course
        $course = $entityManager->getRepository(Course::class)->find($id);
        if (!$course) {
            throw $this->createNotFoundException('Aucune course trouvée pour cet identifiant : '.$id);
        }
         // Récupérez le numéro de téléphone, le nom et le texte du message à partir de la requête
         $number = '+21653360028'; // Remplacez par la variable qui contient le numéro de téléphone destinataire
         $name = $request->request->get('name'); // Si vous avez besoin du nom, sinon vous pouvez le retirer
         $text = ' chere client votre vers  ' .$course->getDestination().' est annulee';
    
        // Supprimez l'entité Course
        $entityManager->remove($course);
        $entityManager->flush();
    
        // Envoyez un SMS après la suppression de la course en utilisant le service TwilioService
        $twilioService->sendSMS($number, $text);
    
        // Redirigez l'utilisateur vers la page d'index des courses
        return $this->redirectToRoute('course_index');
    }
    



 


  



}
