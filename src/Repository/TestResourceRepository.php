<?php

namespace App\Repository;

use App\Entity\TestResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestResource>
 *
 * @method TestResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestResource[]    findAll()
 * @method TestResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestResource::class);
    }

//    /**
//     * @return TestResource[] Returns an array of TestResource objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TestResource
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
