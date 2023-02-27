<?php

namespace App\Entity;

use App\Repository\MaterialSectorSignItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterialSectorSignItemRepository::class)
 */
class MaterialSectorSignItem extends AbstractSignItem
{
}
