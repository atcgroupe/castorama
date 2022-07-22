<?php

namespace App\Entity;

use App\Repository\MaterialAlgecoSignItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterialAlgecoSignItemRepository::class)
 */
class MaterialAlgecoSignItem extends AbstractSignItem
{
}
