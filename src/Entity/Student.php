<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $NSC = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Classroom $classroom = null;

    #[ORM\ManyToMany(targetEntity: Club::class, inversedBy: 'students')]
    private Collection $club;


    public function __construct()
    {
        $this->clubs = new ArrayCollection();
        $this->club = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNSC(): ?int
    {
        return $this->NSC;
    }

    public function setNSC(int $NSC): self
    {
        $this->NSC = $NSC;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * @return Collection<int, Club>
     */
    public function getClub(): Collection
    {
        return $this->club;
    }

    public function addClub(Club $club): self
    {
        if (!$this->club->contains($club)) {
            $this->club->add($club);
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        $this->club->removeElement($club);

        return $this;
    }
}

