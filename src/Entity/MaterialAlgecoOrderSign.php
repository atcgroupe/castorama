<?php

namespace App\Entity;

use App\Repository\MaterialAlgecoOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaterialAlgecoOrderSignRepository::class)
 * @UniqueEntity(
 *     fields={"order", "item1", "item2", "item3", "item4"},
 *     errorPath="item4",
 *     message="Un panneau identique existe déjà dans cette commande"
 * )
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
     * @ORM\ManyToOne(targetEntity=MaterialAlgecoSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $item1;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialAlgecoSignItem::class)
     */
    private $item2;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialAlgecoSignItem::class)
     */
    private $item3;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialAlgecoSignItem::class)
     */
    private $item4;

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

    public function getItem1(): ?MaterialAlgecoSignItem
    {
        return $this->item1;
    }

    public function setItem1(?MaterialAlgecoSignItem $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?MaterialAlgecoSignItem
    {
        return $this->item2;
    }

    public function setItem2(?MaterialAlgecoSignItem $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    public function getItem3(): ?MaterialAlgecoSignItem
    {
        return $this->item3;
    }

    public function setItem3(?MaterialAlgecoSignItem $item3): self
    {
        $this->item3 = $item3;

        return $this;
    }

    public function getItem4(): ?MaterialAlgecoSignItem
    {
        return $this->item4;
    }

    public function setItem4(?MaterialAlgecoSignItem $item4): self
    {
        $this->item4 = $item4;

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
     * @Groups({"api_json_data"})
     * @SerializedName("item1Label")
     */
    public function getItem1Label(): string
    {
        return (null === $this->getItem1()) ? '' : '• ' . $this->getItem1()->getLabel();
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("item2Label")
     */
    public function getItem2Label(): string
    {
        return (null === $this->getItem2()) ? '' : '• ' . $this->getItem2()->getLabel();
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("item3Label")
     */
    public function getItem3Label(): string
    {
        return (null === $this->getItem3()) ? '' : '• ' . $this->getItem3()->getLabel();
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("item4Label")
     */
    public function getItem4Label(): string
    {
        return (null === $this->getItem4()) ? '' : '• ' . $this->getItem4()->getLabel();
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
