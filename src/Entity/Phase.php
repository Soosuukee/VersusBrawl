<?php

namespace App\Entity;

use App\Repository\PhaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\MatchGame;

#[ORM\Entity(repositoryClass: PhaseRepository::class)]
class Phase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'phases')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'phases')]
    private Collection $teams;

    #[ORM\Column]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column]
    private ?bool $isFinished = null;

    #[ORM\Column(length: 255)]
    private ?string $roundLabelingMode = null;

    /**
     * @var Collection<int, MatchGame>
     */
    #[ORM\OneToMany(targetEntity: MatchGame::class, mappedBy: 'phase', orphanRemoval: true)]
    private Collection $matchGames;

    #[ORM\Column(nullable: true)]
    private ?int $phaseOrder = null;

    /**
     * @var Collection<int, ScoringRule>
     */
    #[ORM\OneToMany(targetEntity: ScoringRule::class, mappedBy: 'phase')]
    private Collection $scoringRules;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->matchGames = new ArrayCollection();
        $this->scoringRules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        $this->teams->removeElement($team);

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

    public function getRoundLabelingMode(): ?string
    {
        return $this->roundLabelingMode;
    }

    public function setRoundLabelingMode(string $roundLabelingMode): static
    {
        $this->roundLabelingMode = $roundLabelingMode;

        return $this;
    }

    /**
     * @return Collection<int, MatchGame>
     */
    public function getMatchGames(): Collection
    {
        return $this->matchGames;
    }

    public function addMatchGame(MatchGame $MatchGame): static
    {
        if (!$this->matchGames->contains($MatchGame)) {
            $this->matchGames->add($MatchGame);
            $MatchGame->setPhase($this);
        }

        return $this;
    }

    public function removeMatchGame(MatchGame $MatchGame): static
    {
        if ($this->matchGames->removeElement($MatchGame)) {
            // set the owning side to null (unless already changed)
            if ($MatchGame->getPhase() === $this) {
                $MatchGame->setPhase(null);
            }
        }

        return $this;
    }

    public function getPhaseOrder(): ?int
    {
        return $this->phaseOrder;
    }

    public function setPhaseOrder(?int $phaseOrder): static
    {
        $this->phaseOrder = $phaseOrder;

        return $this;
    }

    /**
     * @return Collection<int, ScoringRule>
     */
    public function getScoringRules(): Collection
    {
        return $this->scoringRules;
    }

    public function addScoringRule(ScoringRule $scoringRule): static
    {
        if (!$this->scoringRules->contains($scoringRule)) {
            $this->scoringRules->add($scoringRule);
            $scoringRule->setPhase($this);
        }

        return $this;
    }

    public function removeScoringRule(ScoringRule $scoringRule): static
    {
        if ($this->scoringRules->removeElement($scoringRule)) {
            // set the owning side to null (unless already changed)
            if ($scoringRule->getPhase() === $this) {
                $scoringRule->setPhase(null);
            }
        }

        return $this;
    }
}
