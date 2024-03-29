<?php

namespace App\Repository;

use App\Entity\SearchClient;
use App\Entity\UserDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDetails[]    findAll()
 * @method UserDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDetail::class);
    }

    public function findBySearch(SearchClient $searchClient): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.lastname LIKE :lastname')
            ->setParameter('lastname', '%' . $searchClient->getLastname() . '%')
            ->getQuery()
            ->getResult();
    }

    /**
    //  * @return UserDetails[] Returns an array of UserDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserDetails
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
