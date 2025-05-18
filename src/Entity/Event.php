<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: 'integer')]
    private int $requiredPlayers;

    #[ORM\Column(type: 'text', nullable: false)]
    private ?string $description = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isRankedByPoints = false;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'createdEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $CreatedBy = null;

    /**
     * @var Collection<int, EventTeam>
     */
    #[ORM\OneToMany(targetEntity: EventTeam::class, mappedBy: 'event')]
    private Collection $participants;

    /**
     * @var Collection<int, Phase>
     */
    #[ORM\OneToMany(targetEntity: Phase::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $phases;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->phases = new ArrayCollection();
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

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
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

    public function getRequiredPlayers(int $requiredPlayers): ?int
    {
        return $this->requiredPlayers;
    }

    public function setRequiredPlayers(int $requiredPlayers): static

    {
        $this->requiredPlayers = $requiredPlayers;

        return $this;
    }

    public function getDescription(string $description): ?string

    {
        return $this->description;
    }

    public function setDescription(int $Description): static

    {
        $this->requiredPlayers = $Description;

        return $this;
    }

    public function isRankedByPoints(): bool
    {
        return $this->isRankedByPoints;
    }

    public function setIsRankedByPoints(bool $isRankedByPoints): static
    {
        $this->isRankedByPoints = $isRankedByPoints;
        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(?User $CreatedBy): static
    {
        $this->CreatedBy = $CreatedBy;

        return $this;
    }

    /**
     * @return Collection<int, EventTeam>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(EventTeam $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setEvent($this);
        }

        return $this;
    }

    public function removeParticipant(EventTeam $participant): static
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getEvent() === $this) {
                $participant->setEvent(null);
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
            $phase->setEvent($this);
        }

        return $this;
    }

    public function removePhase(Phase $phase): static
    {
        if ($this->phases->removeElement($phase)) {
            // set the owning side to null (unless already changed)
            if ($phase->getEvent() === $this) {
                $phase->setEvent(null);
            }
        }

        return $this;
    }
}
