<?php

namespace App\Entity;

use App\Repository\MatchgameParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, PlayerStats>
     */
    #[ORM\OneToMany(targetEntity: PlayerStats::class, mappedBy: 'MatchParticipant', orphanRemoval: true)]
    private Collection $playerStats;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $isDisqualified = false;

    #[ORM\Column(nullable: true)]
    private ?int $eliminationsTotal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note = null;

    public function __construct()
    {
        $this->playerStats = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, PlayerStats>
     */
    public function getPlayerStats(): Collection
    {
        return $this->playerStats;
    }

    public function addPlayerStat(PlayerStats $playerStat): static
    {
        if (!$this->playerStats->contains($playerStat)) {
            $this->playerStats->add($playerStat);
            $playerStat->setMatchParticipant($this);
        }

        return $this;
    }

    public function removePlayerStat(PlayerStats $playerStat): static
    {
        if ($this->playerStats->removeElement($playerStat)) {
            // set the owning side to null (unless already changed)
            if ($playerStat->getMatchParticipant() === $this) {
                $playerStat->setMatchParticipant(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isDisqualified(): ?bool
    {
        return $this->isDisqualified;
    }

    public function setIsDisqualified(bool $isDisqualified): static
    {
        $this->isDisqualified = $isDisqualified;

        return $this;
    }

    public function getEliminationsTotal(): ?int
    {
        return $this->eliminationsTotal;
    }

    public function setEliminationsTotal(?int $eliminationsTotal): static
    {
        $this->eliminationsTotal = $eliminationsTotal;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }
}
