<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(length: 50, unique: true)]
    private ?string $username = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'CreatedBy')]
    private Collection $createdEvents;

    #[ORM\OneToMany(targetEntity: MatchGameParticipant::class, mappedBy: 'player')]
    private Collection $matchGameParticipants;

    #[ORM\OneToMany(targetEntity: PlayerStats::class, mappedBy: 'player')]
    private Collection $playerStats;

    #[ORM\OneToMany(targetEntity: TeamMember::class, mappedBy: 'player', orphanRemoval: true)]
    private Collection $teamMembers;

    /**
     * @var Collection<int, EventUser>
     */
    #[ORM\OneToMany(targetEntity: EventUser::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $eventUsers;

    public function __construct()
    {
        $this->createdEvents = new ArrayCollection();
        $this->matchGameParticipants = new ArrayCollection();
        $this->playerStats = new ArrayCollection();
        $this->teamMembers = new ArrayCollection();
        $this->eventUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void {}

    public function __toString(): string
    {
        return $this->username ?? 'User#' . $this->id;
    }

    public function getCreatedEvents(): Collection
    {
        return $this->createdEvents;
    }

    public function addCreatedEvent(Event $createdEvent): static
    {
        if (!$this->createdEvents->contains($createdEvent)) {
            $this->createdEvents->add($createdEvent);
            $createdEvent->setCreatedBy($this);
        }
        return $this;
    }

    public function removeCreatedEvent(Event $createdEvent): static
    {
        if ($this->createdEvents->removeElement($createdEvent)) {
            if ($createdEvent->getCreatedBy() === $this) {
                $createdEvent->setCreatedBy(null);
            }
        }
        return $this;
    }

    public function getMatchGameParticipants(): Collection
    {
        return $this->matchGameParticipants;
    }

    public function addMatchGameParticipant(MatchGameParticipant $matchGameParticipant): static
    {
        if (!$this->matchGameParticipants->contains($matchGameParticipant)) {
            $this->matchGameParticipants->add($matchGameParticipant);
            $matchGameParticipant->setPlayer($this);
        }
        return $this;
    }

    public function removeMatchGameParticipant(MatchGameParticipant $matchGameParticipant): static
    {
        if ($this->matchGameParticipants->removeElement($matchGameParticipant)) {
            if ($matchGameParticipant->getPlayer() === $this) {
                $matchGameParticipant->setPlayer(null);
            }
        }
        return $this;
    }

    public function getPlayerStats(): Collection
    {
        return $this->playerStats;
    }

    public function addPlayerStat(PlayerStats $playerStat): static
    {
        if (!$this->playerStats->contains($playerStat)) {
            $this->playerStats->add($playerStat);
            $playerStat->setPlayer($this);
        }
        return $this;
    }

    public function removePlayerStat(PlayerStats $playerStat): static
    {
        if ($this->playerStats->removeElement($playerStat)) {
            if ($playerStat->getPlayer() === $this) {
                $playerStat->setPlayer(null);
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
            $teamMember->setPlayer($this);
        }
        return $this;
    }

    public function removeTeamMember(TeamMember $teamMember): static
    {
        if ($this->teamMembers->removeElement($teamMember)) {
            if ($teamMember->getPlayer() === $this) {
                $teamMember->setPlayer(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, EventUser>
     */
    public function getEventUsers(): Collection
    {
        return $this->eventUsers;
    }

    public function addEventUser(EventUser $eventUser): static
    {
        if (!$this->eventUsers->contains($eventUser)) {
            $this->eventUsers->add($eventUser);
            $eventUser->setUser($this);
        }

        return $this;
    }

    public function removeEventUser(EventUser $eventUser): static
    {
        if ($this->eventUsers->removeElement($eventUser)) {
            // set the owning side to null (unless already changed)
            if ($eventUser->getUser() === $this) {
                $eventUser->setUser(null);
            }
        }

        return $this;
    }
}
