<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findUpcomingFiltered(
        ?\DateTimeInterface $start = null,
        ?\DateTimeInterface $end = null,
        ?string $gameSlug = null,
        ?string $fullMode = null,
        ?string $gameName = null
    ): array {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.game', 'g');

        if (!$start && !$end) {
            $qb->andWhere('e.date >= :today')
                ->setParameter('today', new \DateTimeImmutable('today'));
        }

        if ($start) {
            $qb->andWhere('e.date >= :start')
                ->setParameter('start', $start);
        }

        if ($end) {
            $qb->andWhere('e.date <= :end')
                ->setParameter('end', $end);
        }

        if ($gameSlug) {
            $qb->andWhere('g.slug = :slug')
                ->setParameter('slug', $gameSlug);
        }

        if ($fullMode) {
            $qb->andWhere("CONCAT_WS(' > ', NULLIF(e.category, 'default'), e.mode, e.format) LIKE :fullMode")
                ->setParameter('fullMode', "%$fullMode%");
        }

        if ($gameName) {
            $qb->andWhere('LOWER(g.name) LIKE :gameName')
                ->setParameter('gameName', '%' . strtolower($gameName) . '%');
        }

        return $qb->orderBy('e.date', 'ASC')->getQuery()->getResult();
    }


    public function add(Event $event, bool $flush = false): void
    {
        $this->_em->persist($event);

        if ($flush) {
            $this->_em->flush();
        }
    }

    public function update(Event $event, bool $flush = false): void
    {
        $this->_em->persist($event);

        if ($flush) {
            $this->_em->flush();
        }
    }

    public function delete(Event $event, bool $flush = false): void
    {
        $this->_em->remove($event);

        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findEventByName(string $search): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findEventByGame(Game $game): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.game = :game')
            ->setParameter('game', $game)
            ->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
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

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
