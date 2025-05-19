<?php

namespace App\Entity;

use App\Entity\MatchgameParticipant;
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

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $players = null;

    #[ORM\OneToMany(targetEntity: EventTeam::class, mappedBy: 'team')]
    private Collection $eventParticipations;

    #[ORM\ManyToMany(targetEntity: Phase::class, mappedBy: 'teams')]
    private Collection $phases;

    #[ORM\OneToMany(targetEntity: MatchgameParticipant::class, mappedBy: 'team')]
    private Collection $matchgameparticipants;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: TeamMember::class, cascade: ['persist', 'remove'])]
    private Collection $teamMembers;

    public function __construct()
    {
        $this->eventParticipations = new ArrayCollection();
        $this->phases = new ArrayCollection();
        $this->matchgameparticipants = new ArrayCollection();
        $this->teamMembers = new ArrayCollection();
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

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function setPlayers(array $players): static
    {
        $this->players = $players;
        return $this;
    }

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
            if ($eventParticipation->getTeam() === $this) {
                $eventParticipation->setTeam(null);
            }
        }
        return $this;
    }

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

    public function getMatchgameParticipants(): Collection
    {
        return $this->matchgameparticipants;
    }

    public function addMatchgameParticipant(MatchgameParticipant $matchParticipant): static
    {
        if (!$this->matchgameparticipants->contains($matchParticipant)) {
            $this->matchgameparticipants->add($matchParticipant);
            $matchParticipant->setTeam($this);
        }
        return $this;
    }

    public function removeMatchgameParticipant(MatchgameParticipant $matchParticipant): static
    {
        if ($this->matchgameparticipants->removeElement($matchParticipant)) {
            if ($matchParticipant->getTeam() === $this) {
                $matchParticipant->setTeam(null);
            }
        }
        return $this;
    }

    public function getTeamMembers(): Collection
    {
        return $this->teamMembers;
    }

    public function addTeamMember(TeamMember $teamMember): static
    {
        if (!$this->teamMembers->contains($teamMember)) {
            $this->teamMembers->add($teamMember);
            $teamMember->setTeam($this);
        }
        return $this;
    }

    public function removeTeamMember(TeamMember $teamMember): static
    {
        if ($this->teamMembers->removeElement($teamMember)) {
            if ($teamMember->getTeam() === $this) {
                $teamMember->setTeam(null);
            }
        }
        return $this;
    }

    public function getCaptain(): ?User
    {
        foreach ($this->teamMembers as $member) {
            if ($member->isCaptain()) {
                return $member->getPlayer();
            }
        }
        return null;
    }
}
