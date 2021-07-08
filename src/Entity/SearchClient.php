<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class SearchClient
{

    private ?string $lastname = null;

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): ?self
    {
        $this->lastname = $lastname;

        return $this;
    }
}
