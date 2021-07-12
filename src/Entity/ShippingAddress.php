<?php

namespace App\Entity;

use App\Repository\ShippingAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShippingAddressRepository::class)
 */
class ShippingAddress
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $address;

    /**
     * @ORM\OneToMany(targetEntity=Command::class, mappedBy="shippingAddress")
     */
    private Collection $chosenAddress;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="shippingAddresses")
     */
    private ?User $user = null;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private ?string $postalCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $town;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $country;

    public function __construct()
    {
        $this->chosenAddress = new ArrayCollection();
    }


    public function __serialize(): array
    {
        return [];
    }

    public function getFullAddresses(): ?string
    {
        return $this->getAddress() . ", " . $this->getTown() .
            ", " . $this->getCountry()  . ", " . $this->getPostalCode();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Command[]
     */
    public function getChosenAddress(): Collection
    {
        return $this->chosenAddress;
    }

    public function addChosenAddress(Command $chosenAddress): self
    {
        if (!$this->chosenAddress->contains($chosenAddress)) {
            $this->chosenAddress[] = $chosenAddress;
            $chosenAddress->setShippingAddress($this);
        }

        return $this;
    }

    public function removeChosenAddress(Command $chosenAddress): self
    {
        if ($this->chosenAddress->removeElement($chosenAddress)) {
            // set the owning side to null (unless already changed)
            if ($chosenAddress->getShippingAddress() === $this) {
                $chosenAddress->setShippingAddress(null);
            }
        }

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

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
