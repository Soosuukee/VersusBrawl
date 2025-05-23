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
        $lastEvents = $eventRepository->findBy([], ['date' => 'DESC'], 5);
        $games = $gameRepository->findAll();

        return $this->render('home/index.html.twig', [
            'lastEvents' => $lastEvents,
            'games' => $games,
        ]);
    }
}
