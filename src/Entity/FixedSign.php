<?php

namespace App\Entity;

use App\Repository\FixedSignRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FixedSignRepository::class)
 */
class FixedSign extends AbstractSign
{
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
