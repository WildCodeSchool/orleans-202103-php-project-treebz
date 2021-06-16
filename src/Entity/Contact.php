<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    private int $id;

    /**
     * @Assert\NotBlank(message="Ce champ est requis")
     * @Assert\Length(max="255")
     */

    private string $lastname;

    /**
     * @Assert\NotBlank(message="Ce champ est requis")
     * @Assert\Length(max="255")
     */

    private string $firstname;

    /**
     * @Assert\NotBlank(message="Ce champ est requis")
     * @Assert\Length(max="255")
     * @Assert\Email(
     *     message = "Le format de l'adresse email saisie n'est pas valide"
     * )
     */

    private string $email;

    /**
     * @Assert\NotBlank(message="Ce champ est requis")
     * @Assert\Length(max="255")
     */

    private string $object;

    /**
     * @Assert\NotBlank(message="Ce champ est requis")
     */

    private string $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
