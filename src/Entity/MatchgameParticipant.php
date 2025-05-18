<?php

namespace App\Entity;

use App\Repository\MatchgameParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchgameParticipantRepository::class)]
class MatchgameParticipant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $score = null;

    #[ORM\Column]
    private ?int $placement = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isWinner = null;

    #[ORM\ManyToOne(inversedBy: 'MatchgameParticipants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Matchgame $Matchgame = null;

    #[ORM\ManyToOne(inversedBy: 'MatchgameParticipants')]
    private ?Team $team = null;

    #[ORM\ManyToOne(inversedBy: 'MatchgameParticipants')]
    private ?User $player = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getPlacement(): ?int
    {
        return $this->placement;
    }

    public function setPlacement(int $placement): static
    {
        $this->placement = $placement;

        return $this;
    }

    public function isWinner(): ?bool
    {
        return $this->isWinner;
    }

    public function setIsWinner(?bool $isWinner): static
    {
        $this->isWinner = $isWinner;

        return $this;
    }

    public function getMatchgame(): ?Matchgame
    {
        return $this->Matchgame;
    }

    public function setMatchgame(?Matchgame $Matchgame): static
    {
        $this->Matchgame = $Matchgame;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): static
    {
        $this->player = $player;

        return $this;
    }
}
