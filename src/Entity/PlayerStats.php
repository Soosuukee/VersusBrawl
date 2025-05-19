<?php

namespace App\Entity;

use App\Repository\PlayerStatsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerStatsRepository::class)]
class PlayerStats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $eliminations = null;

    #[ORM\Column(nullable: true)]
    private ?int $deaths = null;

    #[ORM\Column(nullable: true)]
    private ?int $assists = null;

    #[ORM\Column(nullable: true)]
    private ?int $damage = null;

    #[ORM\Column(nullable: true)]
    private ?int $headshots = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $externalId = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $source = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $playerScore = null;


    #[ORM\ManyToOne(inversedBy: 'playerStats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MatchgameParticipant $matchParticipant = null;

    #[ORM\ManyToOne(inversedBy: 'playerStats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $player = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEliminations(): ?int
    {
        return $this->eliminations;
    }

    public function setEliminations(int $eliminations): static
    {
        $this->eliminations = $eliminations;

        return $this;
    }

    public function getDeaths(): ?int
    {
        return $this->deaths;
    }

    public function setDeaths(?int $deaths): static
    {
        $this->deaths = $deaths;

        return $this;
    }

    public function getAssists(): ?int
    {
        return $this->assists;
    }

    public function setAssists(?int $assists): static
    {
        $this->assists = $assists;

        return $this;
    }

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(?int $damage): static
    {
        $this->damage = $damage;

        return $this;
    }

    public function getHeadshots(): ?int
    {
        return $this->headshots;
    }

    public function setHeadshots(?int $headshots): static
    {
        $this->headshots = $headshots;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): static
    {
        $this->externalId = $externalId;
        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): static
    {
        $this->source = $source;
        return $this;
    }

    public function getPlayerScore(): ?float
    {
        return $this->playerScore;
    }

    public function setPlayerScore(?float $playerScore): static
    {
        $this->playerScore = $playerScore;
        return $this;
    }

    public function getMatchParticipant(): ?MatchgameParticipant
    {
        return $this->matchParticipant;
    }

    public function setMatchParticipant(?MatchgameParticipant $matchParticipant): static
    {
        $this->matchParticipant = $matchParticipant;

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
