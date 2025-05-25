<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\TeamMember;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/team')]
class TeamController extends AbstractController
{
    #[Route('/new', name: 'app_team_new')]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('teams_images_directory'),
                        $newFilename
                    );
                    $team->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', "Erreur lors de l'upload de l'image.");
                }
            }

            $user = $this->getUser();
            if ($user) {
                $teamMember = new TeamMember();
                $teamMember->setTeam($team);
                $teamMember->setPlayer($user);
                $teamMember->setIsCaptain(true);
                $em->persist($teamMember);
            }

            $em->persist($team);
            $em->flush();

            $this->addFlash('success', 'Équipe créée avec succès !');
            return $this->redirectToRoute('app_event');
        }

        return $this->render('team/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/mes-equipes', name: 'app_user_teams')]
    public function myTeams(TeamRepository $teamRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir vos équipes.');
        }

        $teams = $teamRepository->findTeamsForUser($user);

        return $this->render('team/my_teams.html.twig', [
            'teams' => $teams,
        ]);
    }

    #[Route('/{id}', name: 'app_team_show')]
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_edit')]
    public function edit(Request $request, Team $team, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        if ($team->getCaptain() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Seul le capitaine peut modifier l\'équipe.');
        }

        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('teams_images_directory'),
                        $newFilename
                    );
                    $team->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', "Erreur lors de l'upload de l'image.");
                }
            }

            $em->flush();
            $this->addFlash('success', 'Équipe modifiée avec succès.');
            return $this->redirectToRoute('app_team_show', ['id' => $team->getId()]);
        }

        return $this->render('team/edit.html.twig', [
            'form' => $form->createView(),
            'team' => $team,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_team_delete', methods: ['POST'])]
    public function delete(Request $request, Team $team, EntityManagerInterface $em): Response
    {
        if ($team->getCaptain() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Seul le capitaine peut supprimer l\'équipe.');
        }

        if ($this->isCsrfTokenValid('delete-team-' . $team->getId(), $request->request->get('_token'))) {
            $em->remove($team);
            $em->flush();
            $this->addFlash('success', 'Équipe supprimée avec succès.');
        }

        return $this->redirectToRoute('app_user_teams');
    }

    #[Route('/{id}/leave', name: 'app_team_leave', methods: ['POST'])]
    public function leave(Request $request, Team $team, EntityManagerInterface $em): Response
    {
        if ($team->getCaptain() === $this->getUser()) {
            throw $this->createAccessDeniedException('Le capitaine ne peut pas quitter l\'équipe sans la supprimer.');
        }

        $teamMember = null;
        foreach ($team->getTeamMembers() as $tm) {
            if ($tm->getPlayer() === $this->getUser()) {
                $teamMember = $tm;
                break;
            }
        }

        if (!$teamMember) {
            throw $this->createNotFoundException('Vous n\'êtes pas membre de cette équipe.');
        }

        if ($this->isCsrfTokenValid('leave-team-' . $team->getId(), $request->request->get('_token'))) {
            $team->removeTeamMember($teamMember);
            $em->flush();
            $this->addFlash('success', 'Vous avez quitté l\'équipe avec succès.');
        }

        return $this->redirectToRoute('app_user_teams');
    }
}
