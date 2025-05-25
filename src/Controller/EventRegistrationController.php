<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventTeam;
use App\Entity\EventUser;
use App\Repository\EventTeamRepository;
use App\Repository\EventUserRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/event')]
class EventRegistrationController extends AbstractController
{
    #[Route('/{slug}/{id}/registrations', name: 'app_event_registrations')]
    public function registrations(
        string $slug,
        Event $event,
        EventUserRepository $eventUserRepo,
        EventTeamRepository $eventTeamRepo
    ): Response {
        $this->denyAccessUnlessGranted('EVENT_EDIT', $event);

        $pendingUsers = [];
        $pendingTeams = [];

        if ($event->isSolo()) {
            $pendingUsers = $eventUserRepo->findBy([
                'event' => $event,
                'isValidated' => false,
            ]);
        } else {
            $pendingTeams = $eventTeamRepo->findBy([
                'event' => $event,
                'isValidated' => false,
            ]);
        }

        return $this->render('event/registrations.html.twig', [
            'event' => $event,
            'pendingUsers' => $pendingUsers,
            'pendingTeams' => $pendingTeams,
        ]);
    }

    #[Route('/{slug}/{id}/register-solo', name: 'app_event_register_solo')]
    public function registerSolo(
        string $slug,
        Event $event,
        EntityManagerInterface $em,
        EventUserRepository $eventUserRepository
    ): Response {
        $user = $this->getUser();

        if (!$event->isSolo()) {
            $this->addFlash('error', 'Cet événement n\'est pas solo.');
            return $this->redirectToRoute('app_event_show', [
                'id' => $event->getId(),
                'slug' => $event->getGame()->getSlug()
            ]);
        }

        if ($eventUserRepository->isUserRegistered($event, $user)) {
            $this->addFlash('warning', 'Vous êtes déjà inscrit à cet événement.');
            return $this->redirectToRoute('app_event_show', [
                'id' => $event->getId(),
                'slug' => $event->getGame()->getSlug()
            ]);
        }

        $eventUser = new EventUser();
        $eventUser->setEvent($event);
        $eventUser->setUser($user);
        $eventUser->setIsValidated(false);
        $eventUser->setPointsTotal(null);
        $eventUser->setRanking(null);
        $eventUser->setNote(null);

        $em->persist($eventUser);
        $em->flush();

        $this->addFlash('success', 'Inscription effectuée avec succès !');
        return $this->redirectToRoute('app_event_show', [
            'id' => $event->getId(),
            'slug' => $event->getGame()->getSlug()
        ]);
    }

    #[Route('/{slug}/{id}/register-team/{teamId}', name: 'app_event_register_team')]
    public function registerTeam(
        string $slug,
        Event $event,
        int $teamId,
        EntityManagerInterface $em,
        TeamRepository $teamRepo,
        EventTeamRepository $eventTeamRepo
    ): Response {
        $user = $this->getUser();

        if ($event->isSolo()) {
            $this->addFlash('error', 'Cet événement est solo, vous ne pouvez pas y inscrire une équipe.');
            return $this->redirectToRoute('app_event_show', [
                'id' => $event->getId(),
                'slug' => $event->getGame()->getSlug()
            ]);
        }

        $team = $teamRepo->find($teamId);
        if (!$team) {
            throw $this->createNotFoundException("Équipe introuvable.");
        }

        if ($team->getCaptain() !== $user) {
            $this->addFlash('error', 'Seul le capitaine peut inscrire cette équipe.');
            return $this->redirectToRoute('app_event_show', [
                'id' => $event->getId(),
                'slug' => $event->getGame()->getSlug()
            ]);
        }

        if ($eventTeamRepo->isTeamRegistered($event, $team)) {
            $this->addFlash('warning', 'Cette équipe est déjà inscrite à cet événement.');
            return $this->redirectToRoute('app_event_show', [
                'id' => $event->getId(),
                'slug' => $event->getGame()->getSlug()
            ]);
        }

        $participation = new EventTeam();
        $participation->setEvent($event);
        $participation->setTeam($team);
        $participation->setIsValidated(false);
        $participation->setPointsTotal(null);
        $participation->setRanking(null);
        $participation->setNote(null);

        $em->persist($participation);
        $em->flush();

        $this->addFlash('success', 'Équipe inscrite avec succès !');
        return $this->redirectToRoute('app_event_show', [
            'id' => $event->getId(),
            'slug' => $event->getGame()->getSlug()
        ]);
    }

    #[Route('/{slug}/{id}/unregister-solo', name: 'app_event_unregister_solo')]
    public function unregisterSolo(
        string $slug,
        Event $event,
        EntityManagerInterface $em,
        EventUserRepository $eventUserRepository
    ): Response {
        $user = $this->getUser();

        if (!$event->isSolo()) {
            $this->addFlash('error', 'Cet événement n\'est pas solo.');
            return $this->redirectToRoute('app_event_show', [
                'id' => $event->getId(),
                'slug' => $event->getGame()->getSlug(),
            ]);
        }

        $eventUser = $eventUserRepository->findOneBy(['event' => $event, 'user' => $user]);

        if (!$eventUser) {
            $this->addFlash('error', 'Vous n\'êtes pas inscrit à cet événement.');
        } else {
            $em->remove($eventUser);
            $em->flush();
            $this->addFlash('success', 'Vous vous êtes désinscrit avec succès.');
        }

        return $this->redirectToRoute('app_event_show', [
            'id' => $event->getId(),
            'slug' => $event->getGame()->getSlug(),
        ]);
    }

    #[Route('/{slug}/{id}/unregister-team/{teamId}', name: 'app_event_unregister_team')]
    public function unregisterTeam(
        string $slug,
        Event $event,
        int $teamId,
        EntityManagerInterface $em,
        TeamRepository $teamRepo,
        EventTeamRepository $eventTeamRepo
    ): Response {
        $user = $this->getUser();

        if ($event->isSolo()) {
            $this->addFlash('error', 'Cet événement est solo, aucune équipe ne peut s\'y inscrire.');
            return $this->redirectToRoute('app_event_show', [
                'id' => $event->getId(),
                'slug' => $event->getGame()->getSlug(),
            ]);
        }

        $team = $teamRepo->find($teamId);
        if (!$team || $team->getCaptain() !== $user) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à désinscrire cette équipe.');
            return $this->redirectToRoute('app_event_show', [
                'id' => $event->getId(),
                'slug' => $event->getGame()->getSlug(),
            ]);
        }

        $eventTeam = $eventTeamRepo->findOneBy(['event' => $event, 'team' => $team]);

        if (!$eventTeam) {
            $this->addFlash('error', 'Cette équipe n\'est pas inscrite à l\'événement.');
        } else {
            $em->remove($eventTeam);
            $em->flush();
            $this->addFlash('success', 'Équipe désinscrite avec succès.');
        }

        return $this->redirectToRoute('app_event_show', [
            'id' => $event->getId(),
            'slug' => $event->getGame()->getSlug(),
        ]);
    }
}
