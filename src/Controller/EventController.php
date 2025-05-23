<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/event')]
final class EventController extends AbstractController
{
    #[Route('', name: 'app_event')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $start = $request->query->get('start');
        $end = $request->query->get('end');
        $game = $request->query->get('game');
        $fullMode = $request->query->get('fullMode');

        $startDate = $start ? new \DateTime($start) : null;
        $endDate = $end ? new \DateTime($end) : null;

        $events = $em->getRepository(Event::class)
            ->findUpcomingFiltered($startDate, $endDate, $game, $fullMode);

        $games = $em->getRepository(\App\Entity\Game::class)->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
            'games' => $games,
            'filters' => [
                'start' => $start,
                'end' => $end,
                'game' => $game,
                'fullMode' => $fullMode,
            ],
        ]);
    }
    #[Route('/{slug}/{id}', name: 'app_event_show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/new', name: 'app_event_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modeValue = $form->get('mode')->getData();
            if ($modeValue) {
                [$category, $mode, $format] = explode('|', $modeValue);
                $event->setCategory($category);
                $event->setMode($mode);
                $event->setFormat($format ?: null);
            }

            $event->setCreatedAt(new \DateTimeImmutable());
            $event->setCreatedBy($this->getUser());

            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Événement créé avec succès !');

            return $this->redirectToRoute('app_event');
        }

        return $this->render('event/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
