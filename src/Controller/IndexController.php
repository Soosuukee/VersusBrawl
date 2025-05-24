<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EventRepository $eventRepository, GameRepository $gameRepository): Response
    {
        $today = new \DateTimeImmutable('today');

        $upcomingEvents = $eventRepository->createQueryBuilder('e')
            ->where('e.date >= :today')
            ->setParameter('today', $today)
            ->orderBy('e.date', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        $games = $gameRepository->findAll();

        return $this->render('home/index.html.twig', [
            'lastEvents' => $upcomingEvents,
            'games' => $games,
        ]);
    }
}
