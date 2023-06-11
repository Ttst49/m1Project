<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: User::class)]
    private Collection $m1;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Image::class,cascade: ["persist"] , orphanRemoval: true)]
    private Collection $images;

    #[ORM\OneToOne(inversedBy: 'chosenByBachelor', cascade: ['persist', 'remove'])]
    private ?User $bachelor = null;

    public function __construct()
    {
        $this->m1 = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getM1(): Collection
    {
        return $this->m1;
    }

    public function addM1(User $m1): self
    {
        if (!$this->m1->contains($m1)) {
            $this->m1->add($m1);
            $m1->setProject($this);
        }

        return $this;
    }

    public function removeM1(User $m1): self
    {
        if ($this->m1->removeElement($m1)) {
            // set the owning side to null (unless already changed)
            if ($m1->getProject() === $this) {
                $m1->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProject($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProject() === $this) {
                $image->setProject(null);
            }
        }

        return $this;
    }

    public function getBachelor(): ?User
    {
        return $this->bachelor;
    }

    public function setBachelor(?User $bachelor): self
    {
        $this->bachelor = $bachelor;

        return $this;
    }
}
