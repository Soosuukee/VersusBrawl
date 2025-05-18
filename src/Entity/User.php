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

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'CreatedBy')]
    private Collection $createdEvents;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\OneToMany(targetEntity: Team::class, mappedBy: 'captain')]
    private Collection $teams;

    /**
     * @var Collection<int, matchgameparticipant>
     */
    #[ORM\OneToMany(targetEntity: matchgameparticipant::class, mappedBy: 'player')]
    private Collection $matchgameparticipants;

    public function __construct()
    {
        $this->createdEvents = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->matchgameparticipants = new ArrayCollection();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }


    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __toString(): string
    {
        return $this->username ?? 'User#' . $this->id;
    }

    /**
     * @return Collection<int, Event>
     */
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
            // set the owning side to null (unless already changed)
            if ($createdEvent->getCreatedBy() === $this) {
                $createdEvent->setCreatedBy(null);
            }
        }

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
            $team->setCaptain($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getCaptain() === $this) {
                $team->setCaptain(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matchgameparticipant>
     */
    public function getmatchgameparticipants(): Collection
    {
        return $this->matchgameparticipants;
    }

    public function addmatchgameparticipant(Matchgameparticipant $matchgameparticipant): static
    {
        if (!$this->matchgameparticipants->contains($matchgameparticipant)) {
            $this->matchgameparticipants->add($matchgameparticipant);
            $matchgameparticipant->setPlayer($this);
        }

        return $this;
    }

    public function removeMatchParticipant(MatchgameParticipant $matchgameparticipant): static
    {
        if ($this->matchgameparticipants->removeElement($matchgameparticipant)) {
            // set the owning side to null (unless already changed)
            if ($matchgameparticipant->getPlayer() === $this) {
                $matchgameparticipant->setPlayer(null);
            }
        }

        return $this;
    }
}
