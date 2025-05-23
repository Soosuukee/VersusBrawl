<?php

namespace App\Entity;

use App\Constant\GameModes;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[Assert\Callback('validateGameMode')]
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

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $mode = null;

    #[ORM\Column(length: 50)]
    private string $scoringMode = 'standard';

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $format = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'createdEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $CreatedBy = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: ScoringRule::class, cascade: ['persist', 'remove'])]
    private Collection $scoringRules;

    #[ORM\OneToMany(targetEntity: EventTeam::class, mappedBy: 'event')]
    private Collection $participants;

    #[ORM\OneToMany(targetEntity: Phase::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $phases;

    #[ORM\Column]
    private ?bool $isSolo = null;

    /**
     * @var Collection<int, EventUser>
     */
    #[ORM\OneToMany(targetEntity: EventUser::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $eventUsers;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->phases = new ArrayCollection();
        $this->scoringRules = new ArrayCollection();
        $this->eventUsers = new ArrayCollection();
    }

    public static function validateGameMode(self $event, ExecutionContextInterface $context): void
    {
        $game = $event->getGame();
        if (!$game) {
            return;
        }

        $slug = $game->getSlug();

        if ($event->getCategory() && !in_array($event->getCategory(), GameModes::getCategoriesForGame($slug))) {
            $context->buildViolation('Catégorie invalide pour ce jeu.')
                ->atPath('category')
                ->addViolation();
        }

        if ($event->getCategory() && $event->getMode()) {
            $validModes = array_keys(GameModes::getModesForGameAndCategory($slug, $event->getCategory()));
            if (!in_array($event->getMode(), $validModes)) {
                $context->buildViolation('Mode invalide pour cette catégorie.')
                    ->atPath('mode')
                    ->addViolation();
            }
        }

        if ($event->getCategory() && $event->getMode() && $event->getFormat()) {
            if (GameModes::hasSubFormats($slug, $event->getCategory(), $event->getMode())) {
                $validFormats = GameModes::getSubFormats($slug, $event->getCategory(), $event->getMode());
                if (!in_array($event->getFormat(), $validFormats)) {
                    $context->buildViolation('Format invalide pour ce mode.')
                        ->atPath('format')
                        ->addViolation();
                }
            }
        }
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

    public function getRequiredPlayers(): ?int
    {
        return $this->requiredPlayers;
    }
    public function setRequiredPlayers(int $requiredPlayers): static
    {
        $this->requiredPlayers = $requiredPlayers;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }
    public function setMode(?string $mode): static
    {
        $this->mode = $mode;
        return $this;
    }

    public function getScoringMode(): string
    {
        return $this->scoringMode;
    }
    public function setScoringMode(string $scoringMode): static
    {
        $this->scoringMode = $scoringMode;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): static
    {
        $this->format = $format;
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

    public function getScoringRules(): Collection
    {
        return $this->scoringRules;
    }
    public function addScoringRule(ScoringRule $rule): static
    {
        if (!$this->scoringRules->contains($rule)) {
            $this->scoringRules->add($rule);
            $rule->setEvent($this);
        }
        return $this;
    }
    public function removeScoringRule(ScoringRule $rule): static
    {
        $this->scoringRules->removeElement($rule);
        return $this;
    }

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
            if ($participant->getEvent() === $this) {
                $participant->setEvent(null);
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
            $phase->setEvent($this);
        }
        return $this;
    }
    public function removePhase(Phase $phase): static
    {
        if ($this->phases->removeElement($phase)) {
            if ($phase->getEvent() === $this) {
                $phase->setEvent(null);
            }
        }
        return $this;
    }

    public function isSolo(): ?bool
    {
        return $this->isSolo;
    }

    public function setIsSolo(bool $isSolo): static
    {
        $this->isSolo = $isSolo;

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
            $eventUser->setEvent($this);
        }

        return $this;
    }

    public function removeEventUser(EventUser $eventUser): static
    {
        if ($this->eventUsers->removeElement($eventUser)) {
            // set the owning side to null (unless already changed)
            if ($eventUser->getEvent() === $this) {
                $eventUser->setEvent(null);
            }
        }

        return $this;
    }
}
