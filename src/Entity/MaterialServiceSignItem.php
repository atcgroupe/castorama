<?php

namespace App\Entity;

use App\Repository\MaterialServiceSignItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterialServiceSignItemRepository::class)
 */
class MaterialServiceSignItem extends AbstractSignItem
{
    public const COLOR_BLUE = 'blue';
    public const COLOR_YELLOW = 'yellow';

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $color;

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
