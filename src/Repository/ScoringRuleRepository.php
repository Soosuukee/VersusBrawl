<?php

namespace App\Repository;

use App\Entity\ScoringRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ScoringRule>
 */
class ScoringRuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScoringRule::class);
    }

    //    /**
    //     * @return ScoringRule[] Returns an array of ScoringRule objects
    //     */
    //    public function findByTypeAndEvent(string $type, int $eventId): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.type = :type')
    //            ->andWhere('s.event = :event')
    //            ->setParameter('type', $type)
    //            ->setParameter('event', $eventId)
    //            ->orderBy('s.position', 'ASC')
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneByTypeAndPosition(string $type, int $position): ?ScoringRule
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.type = :type')
    //            ->andWhere('s.position = :position')
    //            ->setParameter('type', $type)
    //            ->setParameter('position', $position)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
