<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\TeamMember;
use App\Form\TeamType;
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
}
