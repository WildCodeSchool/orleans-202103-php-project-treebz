<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 * @ORM\Table(name="`member`")
 * //On précise à l’entité que nous utiliserons l’upload du package Vich uploader
 * @Vich\Uploadable
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank()
     * @Assert\Length(max="15")
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="255")
     */
    private string $picture = '';

    /**
     * @Vich\UploadableField(mapping="picture_file", fileNameProperty="picture")
     * @Assert\NotBlank(message="Il faut selectionner une photo, veuillez cliquer sur Parcourir")
     * @Assert\File(
     * maxSize="2048000",
     * mimeTypes = {
     *     "image/png",
     *     "image/jpeg",
     *     "image/jpg",
     *     "image/webp"
     * })
    * @var File
    */
    private $pictureFile;

    /**
     * @ORM\Column(type="datetime")
     * @var Datetime
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function setPictureFile(File $image): self
    {
        $this->pictureFile = $image;
        $this->updatedAt = new DateTime('now');
        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return  Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param  Datetime  $updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt(Datetime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
