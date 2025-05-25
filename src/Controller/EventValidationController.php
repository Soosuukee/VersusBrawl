<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventUser;
use App\Entity\EventTeam;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/event')]
class EventValidationController extends AbstractController
{
    #[Route('/{slug}/{id}/registrations/validate-user/{eventUser}', name: 'app_event_validate_user', methods: ['POST'])]
    public function validateUser(Request $request, Event $event, EventUser $eventUser, EntityManagerInterface $em): RedirectResponse
    {
        $this->denyAccessUnlessGranted('EVENT_EDIT', $event);

        if ($eventUser->getEvent() !== $event) {
            throw $this->createAccessDeniedException();
        }

        if (!$this->isCsrfTokenValid('validate_user_' . $eventUser->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $eventUser->setIsValidated(true);
        $em->flush();
        $this->addFlash('success', 'Joueur validé avec succès.');

        return $this->redirectToRoute('app_event_registrations', [
            'id' => $event->getId(),
            'slug' => $event->getGame()->getSlug(),
        ]);
    }

    #[Route('/{slug}/{id}/registrations/refuse-user/{eventUser}', name: 'app_event_refuse_user', methods: ['POST'])]
    public function refuseUser(Request $request, Event $event, EventUser $eventUser, EntityManagerInterface $em): RedirectResponse
    {
        $this->denyAccessUnlessGranted('EVENT_EDIT', $event);

        if ($eventUser->getEvent() !== $event) {
            throw $this->createAccessDeniedException();
        }

        if (!$this->isCsrfTokenValid('refuse_user_' . $eventUser->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $em->remove($eventUser);
        $em->flush();
        $this->addFlash('success', 'Inscription refusée et supprimée.');

        return $this->redirectToRoute('app_event_registrations', [
            'id' => $event->getId(),
            'slug' => $event->getGame()->getSlug(),
        ]);
    }

    #[Route('/{slug}/{id}/registrations/validate-team/{eventTeam}', name: 'app_event_validate_team', methods: ['POST'])]
    public function validateTeam(Request $request, Event $event, EventTeam $eventTeam, EntityManagerInterface $em): RedirectResponse
    {
        $this->denyAccessUnlessGranted('EVENT_EDIT', $event);

        if ($eventTeam->getEvent() !== $event) {
            throw $this->createAccessDeniedException();
        }

        if (!$this->isCsrfTokenValid('validate_team_' . $eventTeam->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $eventTeam->setIsValidated(true);
        $em->flush();
        $this->addFlash('success', 'Équipe validée avec succès.');

        return $this->redirectToRoute('app_event_registrations', [
            'id' => $event->getId(),
            'slug' => $event->getGame()->getSlug(),
        ]);
    }

    #[Route('/{slug}/{id}/registrations/refuse-team/{eventTeam}', name: 'app_event_refuse_team', methods: ['POST'])]
    public function refuseTeam(Request $request, Event $event, EventTeam $eventTeam, EntityManagerInterface $em): RedirectResponse
    {
        $this->denyAccessUnlessGranted('EVENT_EDIT', $event);

        if ($eventTeam->getEvent() !== $event) {
            throw $this->createAccessDeniedException();
        }

        if (!$this->isCsrfTokenValid('refuse_team_' . $eventTeam->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $em->remove($eventTeam);
        $em->flush();
        $this->addFlash('success', 'Inscription refusée et supprimée.');

        return $this->redirectToRoute('app_event_registrations', [
            'id' => $event->getId(),
            'slug' => $event->getGame()->getSlug(),
        ]);
    }
}
