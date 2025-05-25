<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventTeamRepository;
use App\Repository\EventUserRepository;
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
        $gameName = $request->query->get('name');

        $startDate = $start ? new \DateTime($start) : null;
        $endDate = $end ? new \DateTime($end) : null;

        $events = $em->getRepository(Event::class)
            ->findUpcomingFiltered($startDate, $endDate, $game, $fullMode, $gameName);

        $games = $em->getRepository(\App\Entity\Game::class)->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
            'games' => $games,
            'filters' => [
                'start' => $start,
                'end' => $end,
                'game' => $game,
                'fullMode' => $fullMode,
                'name' => $gameName,
            ],
        ]);
    }

    #[Route('/{slug}/{id}', name: 'app_event_show')]
    public function show(Event $event, EventUserRepository $eventUserRepo, EventTeamRepository $eventTeamRepo): Response
    {
        $user = $this->getUser();
        $isRegistered = false;

        if ($user instanceof \App\Entity\User) {
            $user->getTeamMembers()->count();

            if ($event->isSolo()) {
                $isRegistered = $eventUserRepo->isUserRegistered($event, $user);
            } else {
                $team = $user->getCaptainTeam();
                if ($team && $eventTeamRepo->isTeamRegistered($event, $team)) {
                    $isRegistered = true;
                }
            }
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'isRegistered' => $isRegistered,
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

            $this->denyAccessUnlessGranted('EVENT_CREATE', $event);

            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Événement créé avec succès !');
            return $this->redirectToRoute('app_event');
        }

        return $this->render('event/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/manage', name: 'app_event_manage')]
    public function manage(EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('EVENT_MANAGE');

        $user = $this->getUser();
        $repo = $em->getRepository(Event::class);

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            $events = $repo->findBy([], ['date' => 'DESC']);
        } else {
            $events = $repo->findBy(['createdBy' => $user], ['date' => 'DESC']);
        }

        return $this->render('event/manage.html.twig', [
            'events' => $events,
        ]);
    }


    #[Route('/{slug}/{id}/edit', name: 'app_event_edit')]
    public function edit(Event $event, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('EVENT_EDIT', $event);

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

            $em->flush();
            $this->addFlash('success', 'Événement modifié avec succès.');
            return $this->redirectToRoute('app_event_show', [
                'slug' => $event->getGame()->getSlug(),
                'id' => $event->getId(),
            ]);
        }

        return $this->render('event/edit.html.twig', [
            'form' => $form->createView(),
            'event' => $event,
        ]);
    }

    #[Route('/{slug}/{id}/delete', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('EVENT_DELETE', $event);

        if ($this->isCsrfTokenValid('delete-event-' . $event->getId(), $request->request->get('_token'))) {
            $em->remove($event);
            $em->flush();
            $this->addFlash('success', 'Événement supprimé avec succès.');
        }

        return $this->redirectToRoute('app_event');
    }
    #[Route('/{slug}/{id}/registrations', name: 'app_event_registrations')]
    public function registrations(Event $event): Response
    {
        $this->denyAccessUnlessGranted('EVENT_EDIT', $event);

        return $this->render('event/registrations.html.twig', [
            'event' => $event,
        ]);
    }
}
