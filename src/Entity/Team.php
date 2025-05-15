<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'teams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $captain = null;

    #[ORM\Column]
    private array $players = [];

    /**
     * @var Collection<int, EventTeam>
     */
    #[ORM\OneToMany(targetEntity: EventTeam::class, mappedBy: 'team')]
    private Collection $eventParticipations;

    /**
     * @var Collection<int, Phase>
     */
    #[ORM\ManyToMany(targetEntity: Phase::class, mappedBy: 'teams')]
    private Collection $phases;

    /**
     * @var Collection<int, MatchParticipant>
     */
    #[ORM\OneToMany(targetEntity: MatchParticipant::class, mappedBy: 'team')]
    private Collection $matchParticipants;

    public function __construct()
    {
        $this->eventParticipations = new ArrayCollection();
        $this->phases = new ArrayCollection();
        $this->matchParticipants = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCaptain(): ?User
    {
        return $this->captain;
    }

    public function setCaptain(?User $captain): static
    {
        $this->captain = $captain;

        return $this;
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function setPlayers(array $players): static
    {
        $this->players = $players;

        return $this;
    }

    /**
     * @return Collection<int, EventTeam>
     */
    public function getEventParticipations(): Collection
    {
        return $this->eventParticipations;
    }

    public function addEventParticipation(EventTeam $eventParticipation): static
    {
        if (!$this->eventParticipations->contains($eventParticipation)) {
            $this->eventParticipations->add($eventParticipation);
            $eventParticipation->setTeam($this);
        }

        return $this;
    }

    public function removeEventParticipation(EventTeam $eventParticipation): static
    {
        if ($this->eventParticipations->removeElement($eventParticipation)) {
            // set the owning side to null (unless already changed)
            if ($eventParticipation->getTeam() === $this) {
                $eventParticipation->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Phase>
     */
    public function getPhases(): Collection
    {
        return $this->phases;
    }

    public function addPhase(Phase $phase): static
    {
        if (!$this->phases->contains($phase)) {
            $this->phases->add($phase);
            $phase->addTeam($this);
        }

        return $this;
    }

    public function removePhase(Phase $phase): static
    {
        if ($this->phases->removeElement($phase)) {
            $phase->removeTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, MatchParticipant>
     */
    public function getMatchParticipants(): Collection
    {
        return $this->matchParticipants;
    }

    public function addMatchParticipant(MatchParticipant $matchParticipant): static
    {
        if (!$this->matchParticipants->contains($matchParticipant)) {
            $this->matchParticipants->add($matchParticipant);
            $matchParticipant->setTeam($this);
        }

        return $this;
    }

    public function removeMatchParticipant(MatchParticipant $matchParticipant): static
    {
        if ($this->matchParticipants->removeElement($matchParticipant)) {
            // set the owning side to null (unless already changed)
            if ($matchParticipant->getTeam() === $this) {
                $matchParticipant->setTeam(null);
            }
        }

        return $this;
    }
}
