<?php

namespace App\Neo\Repository;

use App\Neo\Entity\Neo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Neo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Neo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Neo[]    findAll()
 * @method Neo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NeoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Neo::class);
    }

    public function findOneByDateAndReference(\DateTime $dateTime, string $reference): ?Neo
    {
        return $this->findOneBy(['date' => $dateTime, 'reference' => $reference]);
    }

    public function save(Neo $neo): void
    {
        $this->_em->persist($neo);
        $this->_em->flush($neo);
    }

    // /**
    //  * @return Neo[] Returns an array of Neo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Neo
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
