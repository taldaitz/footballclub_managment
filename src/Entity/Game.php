<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $teamIn = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $teamOut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Referee $referee = null;

    /**
     * @var Collection<int, Goal>
     */
    #[ORM\OneToMany(targetEntity: Goal::class, mappedBy: 'game')]
    private Collection $goals;

    public function __construct()
    {
        $this->goals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamIn(): ?Team
    {
        return $this->teamIn;
    }

    public function setTeamIn(?Team $teamIn): static
    {
        $this->teamIn = $teamIn;

        return $this;
    }

    public function getTeamOut(): ?Team
    {
        return $this->teamOut;
    }

    public function setTeamOut(?Team $teamOut): static
    {
        $this->teamOut = $teamOut;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getReferee(): ?Referee
    {
        return $this->referee;
    }

    public function setReferee(?Referee $referee): static
    {
        $this->referee = $referee;

        return $this;
    }

    /**
     * @return Collection<int, Goal>
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal): static
    {
        if (!$this->goals->contains($goal)) {
            $this->goals->add($goal);
            $goal->setGame($this);
        }

        return $this;
    }

    public function removeGoal(Goal $goal): static
    {
        if ($this->goals->removeElement($goal)) {
            // set the owning side to null (unless already changed)
            if ($goal->getGame() === $this) {
                $goal->setGame(null);
            }
        }

        return $this;
    }

    public function getDisplayName() : string
    {
        return $this->teamIn->getName() . ' vs ' . $this->teamOut->getName() . ' - ' . $this->date->format('d/m/Y');  
    }

    public function getTeamInScore() : int
    {
        $score = 0;

        foreach($this->getGoals() as $goal)
        {
            if($this->teamIn === $goal->getTeam())
                $score++;
        }

        return $score;
    }

    public function getTeamOutScore() : int
    {
        $score = 0;

        foreach($this->getGoals() as $goal)
        {
            if($this->teamOut === $goal->getTeam())
                $score++;
        }

        return $score;
    }
}
