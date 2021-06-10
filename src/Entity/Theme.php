<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 */
class Theme
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
    private string $name;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank()
     * @Assert\Length(max="500")
     */
    private string $image;

    /**
     * @ORM\Column(type="string", length=7)
     * @Assert\NotBlank()
     * @Assert\Regex("/^#[A-Fa-f]{6}$/")
     * @Assert\Length(max="7")
     */
    private string $colorText;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getColorText(): ?string
    {
        return $this->colorText;
    }

    public function setColorText(string $colorText): self
    {
        $this->colorText = $colorText;

        return $this;
    }
}
