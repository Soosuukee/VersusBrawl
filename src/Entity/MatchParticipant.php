<?php

namespace App\Entity;

use App\Repository\MatchParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchParticipantRepository::class)]
class MatchParticipant
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

    #[ORM\ManyToOne(inversedBy: 'matchParticipants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GameMatch $gameMatch = null;

    #[ORM\ManyToOne(inversedBy: 'matchParticipants')]
    private ?Team $team = null;

    #[ORM\ManyToOne(inversedBy: 'matchParticipants')]
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

    public function getGameMatch(): ?GameMatch
    {
        return $this->gameMatch;
    }

    public function setGameMatch(?GameMatch $gameMatch): static
    {
        $this->gameMatch = $gameMatch;

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
