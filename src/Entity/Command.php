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

    /**
     * @ORM\OneToMany(targetEntity=Member::class, mappedBy="command")
     */
    private Collection $members;

    public function __construct()
    {
        $this->selectedThemes = new ArrayCollection();
        $this->members = new ArrayCollection();
    }

    public function getId(): int
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

    /**
     * @return Collection|Member[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setCommand($this);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getCommand() === $this) {
                $member->setCommand(null);
            }
        }

        return $this;
    }
}
