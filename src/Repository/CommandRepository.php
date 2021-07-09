<?php

namespace App\Repository;

use App\Entity\Command;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\BrowserKit\Response;

/**
 * @method Command|null find($id, $lockMode = null, $lockVersion = null)
 * @method Command|null findOneBy(array $criteria, array $orderBy = null)
 * @method Command[]    findAll()
 * @method Command[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Command::class);
    }

    public function findLikeProjectName(string $name): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.projectName LIKE :projectName')
            ->setParameter('projectName', '%' . $name . '%')
            ->orWhere('c.createdAt LIKE :createdAt')
            ->setParameter('createdAt', '%' . $name . '%')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    public function findLikeStatus(string $status): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.status LIKE :status')
            ->setParameter('status', '%' . $status . '%')
            ->getQuery();

        return $queryBuilder->getResult();
    }
    /*
    public function findOneBySomeField($value): ?Command
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
