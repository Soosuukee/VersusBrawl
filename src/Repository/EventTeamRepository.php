<?php

namespace App\Repository;

use App\Entity\EventTeam;
use App\Entity\Team;
use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventTeam>
 */
class EventTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventTeam::class);
    }

    public function isTeamRegistered(Event $event, Team $team): bool
    {
        return (bool) $this->createQueryBuilder('et')
            ->select('1')
            ->where('et.event = :event')
            ->andWhere('et.team = :team')
            ->setParameter('event', $event)
            ->setParameter('team', $team)
            ->getQuery()
            ->getOneOrNullResult();
    }



    //    /**
    //     * @return EventTeam[] Returns an array of EventTeam objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EventTeam
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
