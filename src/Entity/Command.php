<?php

namespace App\Entity;

use App\Repository\CommandRepository;
use App\Form\CommandType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommandRepository::class)
 */
class Command
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private string $projectName;

    /**
     * @ORM\ManyToMany(targetEntity=Theme::class, inversedBy="commands")
    */
    private Collection $selectedThemes;

    public function __construct()
    {
        $this->selectedThemes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    public function setProjectName(string $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getSelectedThemes(): Collection
    {
        return $this->selectedThemes;
    }

    public function addSelectedTheme(Theme $selectedTheme): self
    {
        if (!$this->selectedThemes->contains($selectedTheme)) {
            $this->selectedThemes[] = $selectedTheme;
        }

        return $this;
    }

    public function removeSelectedTheme(Theme $selectedTheme): self
    {
        $this->selectedThemes->removeElement($selectedTheme);

        return $this;
    }
}
