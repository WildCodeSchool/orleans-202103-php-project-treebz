<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use DateTime;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRepository")
 * @Vich\Uploadable
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
     * @Assert\Length(max="500")
     * @var string
     */
    private string $image = "";

    /**
     * @Vich\UploadableField(mapping="picture_file", fileNameProperty="image")
     * @var File
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="string", length=7)
     * @Assert\NotBlank()
     * @Assert\Regex("/^#[A-Fa-f0-9]{6}$/")
     * @Assert\Length(max="7")
     */
    private string $colorText;

    /**
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    private $updatedAt;

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

    public function setPictureFile(File $image): self
    {
        $this->pictureFile = $image;
        $this->updatedAt = new DateTime('now');
        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
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
