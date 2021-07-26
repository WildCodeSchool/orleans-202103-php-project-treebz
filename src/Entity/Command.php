<?php

namespace App\Entity;

use App\Repository\CommandRepository;
use App\Form\CommandType;
use DateTime;
use DateTimeImmutable;
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
     * @Assert\Length(max="50")
     */
    private string $projectName;

    /**
     * @ORM\ManyToMany(targetEntity=Theme::class, inversedBy="commands")
    */
    private Collection $selectedThemes;

    /**
     * @ORM\OneToMany(targetEntity=Member::class, mappedBy="command", cascade={"remove"})
     */
    private Collection $members;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="commands")
     */
    private Status $status;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $quantity = 1;

    /**
     * @ORM\ManyToOne(targetEntity=UserDetail::class, inversedBy="commands")
     */
    private ?UserDetail $contactInformation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commands")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private ?User $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=ShippingAddress::class, inversedBy="chosenAddress")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?ShippingAddress $shippingAddress;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $price;


    public function __construct()
    {
        $this->setCreatedAt(new DateTimeImmutable());
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

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getContactInformation(): ?UserDetail
    {
        return $this->contactInformation;
    }

    public function setContactInformation(?UserDetail $contactInformation): self
    {
        $this->contactInformation = $contactInformation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getShippingAddress(): ?ShippingAddress
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(?ShippingAddress $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
