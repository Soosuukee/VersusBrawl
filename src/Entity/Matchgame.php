<?php

namespace App\Entity;

use App\Repository\MatchgameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchgameRepository::class)]
class MatchGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Matchgames')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Phase $phase = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column]
    private ?bool $isFinished = null;

    #[ORM\Column(length: 255)]
    private ?string $roundLabel = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $lobbycode = null;

    /**
     * @var Collection<int, MatchgameParticipant>
     */
    #[ORM\OneToMany(targetEntity: MatchgameParticipant::class, mappedBy: 'Matchgame', orphanRemoval: true)]
    private Collection $MatchgameParticipants;

    public function __construct()
    {
        $this->MatchgameParticipants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhase(): ?Phase
    {
        return $this->phase;
    }

    public function setPhase(?Phase $phase): static
    {
        $this->phase = $phase;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function isFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): static
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    public function getRoundLabel(): ?string
    {
        return $this->roundLabel;
    }

    public function setRoundLabel(string $roundLabel): static
    {
        $this->roundLabel = $roundLabel;

        return $this;
    }

    public function getLobbycode(): ?string
    {
        return $this->lobbycode;
    }

    public function setLobbycode(?string $lobbycode): static
    {
        $this->lobbycode = $lobbycode;

        return $this;
    }

    /**
     * @return Collection<int, MatchgameParticipant>
     */
    public function getMatchgameParticipants(): Collection
    {
        return $this->MatchgameParticipants;
    }

    public function addMatchgameParticipant(MatchgameParticipant $MatchgameParticipant): static
    {
        if (!$this->MatchgameParticipants->contains($MatchgameParticipant)) {
            $this->MatchgameParticipants->add($MatchgameParticipant);
            $MatchgameParticipant->setMatchgame($this);
        }

        return $this;
    }

    public function removeMatchgameParticipant(MatchgameParticipant $MatchgameParticipant): static
    {
        if ($this->MatchgameParticipants->removeElement($MatchgameParticipant)) {
            // set the owning side to null (unless already changed)
            if ($MatchgameParticipant->getMatchgame() === $this) {
                $MatchgameParticipant->setMatchgame(null);
            }
        }

        return $this;
    }
}
