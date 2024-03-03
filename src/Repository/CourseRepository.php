<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }
    
    public function countCoursesByWeek(): array
    {

    $courses = $this->createQueryBuilder('c')
            ->select('c.date')
            ->getQuery()
            ->getResult();

        $courseCountByWeek = [];
        foreach ($courses as $course) {
            $weekNumber = (int)$course['date']->format('W');
            if (!isset($courseCountByWeek[$weekNumber])) {
                $courseCountByWeek[$weekNumber] = 0;
            }
            $courseCountByWeek[$weekNumber]++;
        }

        return $courseCountByWeek;
    }

    public function countCoursesByMonth(): array
    {
        $courses = $this->createQueryBuilder('c')
            ->select('c.date')
            ->getQuery()
            ->getResult();

        $courseCountByMonth = [];
        foreach ($courses as $course) {
            $monthNumber = (int)$course['date']->format('n');
            if (!isset($courseCountByMonth[$monthNumber])) {
                $courseCountByMonth[$monthNumber] = 0;
            }
            $courseCountByMonth[$monthNumber]++;
        }

        return $courseCountByMonth;
    }

//    /**
//     * @return Course[] Returns an array of Course objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Course
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
