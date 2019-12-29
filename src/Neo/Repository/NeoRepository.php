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

    public function findAllHazardous(): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->where('q.isHazardous = 1');

        return $qb->getQuery()->getArrayResult();
    }

    public function findFastest(bool $isHazardous): Neo
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

    public function save(Neo $neo): void
    {
        $this->_em->persist($neo);
        $this->_em->flush($neo);
    }
}
