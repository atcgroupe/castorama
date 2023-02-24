<?php

namespace App\Entity;

use App\Repository\MaterialAlgecoOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaterialAlgecoOrderSignRepository::class)
 */
class MaterialAlgecoOrderSign extends AbstractVariableOrderSign
{
    public const DIR_LEFT = 'l';
    public const DIR_RIGHT = 'r';

    /**
     * @ORM\Column(type="integer")
     * @Groups({"api_json_data"})
     * @Assert\NotBlank(message="Le numéro d'allée est obligatoire")
     */
    private $aisleNumber;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $dir;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAisleNumber(): ?int
    {
        return $this->aisleNumber;
    }

    public function setAisleNumber(?int $aisleNumber): self
    {
        $this->aisleNumber = $aisleNumber;

        return $this;
    }

    public function getDir(): ?string
    {
        return $this->dir;
    }

    public function setDir(string $dir): self
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getTemplateFilename(): string
    {
        return sprintf(
            '%s_%s',
            $this->getSign()->getName(),
            $this->getDir()
        );
    }
}
