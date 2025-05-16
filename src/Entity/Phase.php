<?php

namespace App\Entity;

use App\Repository\PhaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Matchgame;

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
     * @var Collection<int, Matchgame>
     */
    #[ORM\OneToMany(targetEntity: Matchgame::class, mappedBy: 'phase', orphanRemoval: true)]
    private Collection $matchgames;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->matchgames = new ArrayCollection();
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
     * @return Collection<int, Matchgame>
     */
    public function getMatchgames(): Collection
    {
        return $this->matchgames;
    }

    public function addMatchgame(Matchgame $Matchgame): static
    {
        if (!$this->matchgames->contains($Matchgame)) {
            $this->matchgames->add($Matchgame);
            $Matchgame->setPhase($this);
        }

        return $this;
    }

    public function removeMatchgame(Matchgame $Matchgame): static
    {
        if ($this->matchgames->removeElement($Matchgame)) {
            // set the owning side to null (unless already changed)
            if ($Matchgame->getPhase() === $this) {
                $Matchgame->setPhase(null);
            }
        }

        return $this;
    }
}
