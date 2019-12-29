<?php

namespace App\Neo\Repository;

use App\Neo\Entity\Neo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function findAllHazardous(): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->where('q.isHazardous = 1');

        return $qb->getQuery()->getArrayResult();
    }

    public function findFastest(bool $isHazardous = false): Neo
    {
        $qb = $this->createQueryBuilder('q');
        $qb
            ->orderBy('q.speed', 'DESC')
            ->setMaxResults(1);

        if ($isHazardous) {
            $qb->andWhere('q.isHazardous = 1');
        }

        return $qb->getQuery()->getSingleResult();
    }

    public function findBestYear(bool $isHazardous = false): array
    {
        $qb = $this->createQueryBuilder('q');

        $qb
            ->select('YEAR(q.date) as gYear, COUNT(q.id) as count')
            ->groupBy('gYear')
            ->orderBy('count', 'DESC')
            ->setMaxResults(1);

        if ($isHazardous) {
            $qb->andWhere('q.isHazardous = 1');
        }

        return $qb->getQuery()->getScalarResult();
    }

    public function findBestMonth(bool $isHazardous = false): array
    {
        $qb = $this->createQueryBuilder('q');

        $qb
            ->select('YEAR(q.date) as gYear, MONTH(q.date) as gMonth, COUNT(q.id) as count')
            ->groupBy('gYear, gMonth')
            ->orderBy('count', 'DESC')
            ->setMaxResults(1);

        if ($isHazardous) {
            $qb->andWhere('q.isHazardous = 1');
        }

        return $qb->getQuery()->getScalarResult();
    }

//    public function findBestMonth(bool $isHazardous = false): int
//    {
//        $qb = $this->createQueryBuilder('q');
//
//        $qb
//            ->select('YEAR(DATE), MONTH(DATE), COUNT(*) as count')
//            ->groupBy('YEAR(DATE), MONTH(DATE)')
//            ->orderBy('count', 'DESC')
//            ->setMaxResults(1);
//
//        if ($isHazardous) {
//            $qb->andWhere('q.isHazardous = 1');
//        }
//
//        return $qb->getQuery()->getSingleScalarResult();
//    }

    public function save(Neo $neo): void
    {
        $this->_em->persist($neo);
        $this->_em->flush($neo);
    }
}
